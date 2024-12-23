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
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/produk');

            if ($response->successful()) {
                $produk = $response->json(); // Decode JSON
                return view('Haikal_managebarang', compact('produk'));
            } else {
                return view('Haikal_managebarang')->with('error', 'Gagal mendapatkan produk dari API');
            }
        } catch (\Exception $e) {
            return view('Haikal_managebarang')->with('error', $e->getMessage());
        }
    }

    public function addproduk(Request $request)
    {
        try {
            Log::info('addproduk called', ['data' => $request->all()]);

            // Prepare the data to send
            $data = [
                'nama_barang' => $request->input('nama_barang'),
                'harga' => $request->input('harga'),
                'deskripsi_barang' => $request->input('deskripsi_barang', ''), // Use empty string if not provided
                'stok' => $request->input('stok'),
                'berat' => $request->input('berat'),
                'id_umkm' => 1 // Hardcoding the id_umkm or can be dynamic
            ];

            Log::info('Data prepared', ['data' => $data]);

            // Create a Guzzle client
            $client = new Client(['verify' => false]);

            // Send the POST request using Guzzle
            $response = $client->post('https://umkmapi.azurewebsites.net/produk', [
                'json' => $data,
            ]);

            // Check if the response is successful
            if ($response->getStatusCode() == 200) {
                return redirect()->route('umkm.managebarang')
                    ->with('success', 'Produk berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menambahkan produk: ' . $response->getBody());
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
