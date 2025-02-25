<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourierController extends Controller
{
    public function check(Request $request)
    {
        $phone = $request->input('phone');

        $response = Http::withHeaders([
            'Authorization' => 'jcDS13SxRAtm69cANU9J1O0DjFKTlk24reQSFCsCw8EGOSG72lsgCz3R5TyG', // Replace with your actual token
        ])->post('https://bdcourier.com/api/courier-check', [
            'phone' => $phone,
        ]);

        return $response->json();
    }
}
