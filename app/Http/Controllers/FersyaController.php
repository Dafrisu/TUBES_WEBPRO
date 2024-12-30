<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


use Illuminate\Support\Facades\Log;

class FersyaController extends Controller
{
    public function getviewinbox()
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('http://localhost/getinboxpesanan');

            if ($response->successful()) {
                $inbox = $response->json(); // Decode JSON
                return view('fersya_inbox', compact('inbox'));
            } else {
                return view('fersya_inbox')->with('error', 'Gagal mendapatkan inbox dari API');
            }
        } catch (\Exception $e) {
            return view('fersya_inbox')->with('error', $e->getMessage());
        }
    }

}
