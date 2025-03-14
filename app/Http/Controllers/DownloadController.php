<?php

namespace App\Http\Controllers;

use App\Models\AppDownloadTrack;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\DownloadTracker;

class DownloadController extends Controller
{
    public function index()
    {
        // Count only completed downloads
        $downloadCount = AppDownloadTrack::where('status', 'completed')->count();
        
        // Get the last download time
        $lastDownload = AppDownloadTrack::where('status', 'completed')
            ->latest('created_at')
            ->first();
            
        $lastDownloadTime = $lastDownload ? $lastDownload->created_at->diffForHumans() : null;
        
        return view('download', compact('downloadCount', 'lastDownloadTime'));
    }
    
    public function trackIntent()
    {
        // Only track the intent without starting the download
        $trackId = AppDownloadTrack::create([
            "ip_address" => request()->ip(),
            "status" => "initiated"
        ])->id;
        
        return response()->json([
            'success' => true,
            'track_id' => $trackId
        ]);
    }
    
    public function download(Request $request)
    {
        // Update the existing record if a track_id is provided
        if ($request->has('track_id')) {
            AppDownloadTrack::where('id', $request->track_id)
                ->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
        }
        
        $file = public_path('assets/FraudShield.apk');
        
        return response()->download($file, 'FraudShield.apk', [
            'Content-Type' => 'application/vnd.android.package-archive'
        ]);
    }

    public function download2(Request $request)
    {
        // Update the existing record if a track_id is provided
       $checkIp = AppDownloadTrack::where('ip_address', request()->ip())->first();
        if ($checkIp) {
            $checkIp->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        } else {
            AppDownloadTrack::create([
                'status' => 'completed',
                'completed_at' => now(),
                'ip_address' => request()->ip()
            ]);
        }
        
        $file = public_path('assets/FraudShield.apk');
        
        return response()->download($file, 'FraudShield.apk', [
            'Content-Type' => 'application/vnd.android.package-archive'
        ]);
    }


    public function trackDownloadIntent(Request $request)
    {
        // Generate a unique tracking ID
        $trackId = Str::uuid();
        
        // Get download format (csv, apk, etc.)
        $format = $request->input('format', 'csv');
        
        // Record the download intent in database
        DownloadTracker::create([
            'track_id' => $trackId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'format' => $format,
            'status' => 'intent', // Track initial intent, will be updated to 'completed' when download starts
            'completed_at' => null,
        ]);
        
        // Return the tracking ID to be used in the actual download request
        return response()->json([
            'success' => true,
            'track_id' => $trackId
        ]);
    }
    
    public function downloadCsv(Request $request)
    {
        $trackId = $request->query('track_id');
        
        // Update the download status if tracking ID exists
        if ($trackId) {
            AppDownloadTrack::where('track_id', $trackId)
                ->where('status', 'intent')
                ->update([
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
        }
        
        // Handle based on requested file type
        $fileType = $request->query('file_type', 'customer'); // Default to customer file
        
        if ($fileType === 'customer') {
            return $this->downloadCustomerData();
        } else if ($fileType === 'analytics') {
            return $this->downloadAnalyticsData();
        } else {
            return response()->json(['error' => 'Invalid file type requested'], 400);
        }
    }
    
    private function downloadCustomerData()
    {
        // Generate CSV data
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customer_data_'.date('Y-m-d').'.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Create a streamed response with CSV data
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 
                'Phone Number', 
                'Count',
                'Data',
                'Search By',
                'IP Address',
                'Last Searched At',
                'Created At'
            ]);
            
            // Fetch records from database and add to CSV
            Customer::chunk(100, function($customers) use ($file) {
                foreach ($customers as $customer) {
                    fputcsv($file, [
                        $customer->id,
                        $customer->phone,
                        $customer->count,
                        $customer->data,
                        $customer->search_by,
                        $customer->ip_address,
                        $customer->last_searched_at,
                        $customer->created_at
                    ]);
                }
            });
            
            // Close the file
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    private function downloadAnalyticsData()
    {
        // Generate CSV data for analytics
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="analytics_data_'.date('Y-m-d').'.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        // Create a streamed response with CSV data
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers for analytics data
            fputcsv($file, [
                'ID', 
                'IP Address', 
                'Status',
                'Completed At',
                'Created At'
            ]);
            
            // Fetch analytics records from database and add to CSV
            AppDownloadTrack::chunk(100, function($records) use ($file) {
                foreach ($records as $record) {
                    fputcsv($file, [
                        $record->id,
                        $record->ip_address,
                        $record->status,
                        $record->completed_at,
                        $record->created_at
                    ]);
                }
            });
            
            // Close the file
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    /**
     * Update download count in the system
     */
   
}
