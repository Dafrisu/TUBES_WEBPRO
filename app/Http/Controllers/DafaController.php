<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DafaController extends Controller
{
    public function getpesananmasuk()
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/pesananmasuk');

            if ($response->successful()) {
                $pesanan = $response->json(); // Decode JSON
                return view('Dafa_kelolaPesanan', compact('pesanan'));
            } else {
                return view('Dafa_kelolaPesanan')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_kelolaPesanan')->with('error', $e->getMessage());
        }
    }
}