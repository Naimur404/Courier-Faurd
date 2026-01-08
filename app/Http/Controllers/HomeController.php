<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'csrfToken' => csrf_token(),
        ]);
    }
    
    /**
     * Show the old Welcome page (kept for reference)
     */
    public function welcome()
    {
        return Inertia::render('Welcome', [
            'csrfToken' => csrf_token(),
        ]);
    }
    
    public function about()
    {
        return Inertia::render('About');
    }
}
