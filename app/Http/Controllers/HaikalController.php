<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HaikalController extends Controller
{


    public function getviewproduk()
    {
        try {
            // Membuat instance dari Guzzle Client
            $client = new Client([
                'verify' => false // Menonaktifkan verifikasi SSL
            ]);

            // Melakukan GET request ke API
            $response = $client->get('https://umkmapi.azurewebsites.net/produk');

            // Mengecek apakah request berhasil dan mendapatkan response body
            if ($response->getStatusCode() == 200) {
                $produk = json_decode($response->getBody()->getContents(), true); // Decode JSON menjadi array

                // Mengirim data ke view
                return view('Haikal_managebarang', compact('produk'));
            } else {
                return view('Haikal_managebarang')->with("error", "Gagal mendapatkan produk dari API");
            }
        } catch (\Exception $e) {
            // Menangkap error jika terjadi kesalahan dalam request
            return view('Haikal_managebarang')->with("error", $e->getMessage());
        }
    }
}
