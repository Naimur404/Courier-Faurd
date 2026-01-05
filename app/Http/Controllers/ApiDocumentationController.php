<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ApiDocumentationController extends Controller
{
    /**
     * Display the API documentation page
     */
    public function index()
    {
        return Inertia::render('Api/Documentation');
    }
}
