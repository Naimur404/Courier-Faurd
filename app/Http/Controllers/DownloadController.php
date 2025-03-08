<?php

namespace App\Http\Controllers;

use App\Models\AppDownloadTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

    public function download2()
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
}
