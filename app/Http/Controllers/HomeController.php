<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function home()
    {
        return Inertia::render('Welcome', [
            'csrfToken' => csrf_token(),
        ]);
    }
    
    public function about()
    {
        return view('about');
    }
}
