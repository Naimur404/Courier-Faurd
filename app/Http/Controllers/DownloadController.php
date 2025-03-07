<?php

namespace App\Http\Controllers;

use App\Models\AppDownloadTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DownloadController extends Controller
{
    public function index()
    {
        // Get the download count
        $downloadCount = AppDownloadTrack::count();
        
        // Get the last download time
        $lastDownload = AppDownloadTrack::latest('created_at')->first();
        $lastDownloadTime = null;
        
        if ($lastDownload) {
            // Format the last download time nicely
            $lastDownloadTime = $lastDownload->created_at->diffForHumans();
        }
        
        return view('download', compact('downloadCount', 'lastDownloadTime'));
    }
    
    public function download()
    {
        AppDownloadTrack::track(request()->ip());

        $file = public_path('assets/FraudShield.apk');
        
        return response()->download($file, 'FraudShield.apk', [
            'Content-Type' => 'application/vnd.android.package-archive'
        ]);
    }
}
