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

    public function getUpdateprodukview($id)
    {
        try {
            if (!$id) {
                throw new \Exception('ID Produk tidak ditemukan');
            }

            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/produk/' . $id);

            if ($respose->successful()) {
                $produk = $respose->json();
                return view('Haikal_pageUpdatebarang', compact('produk'));
            } else {
                throw new \Exception('Tidak menemukan barang ang dicari');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.managebarang')->with('error', $e->getMessage());
        }
    }

    public function addproduk(Request $request)
    {
        try {
            Log::info('addproduk called', ['data' => $request->all()]);

            // Prepare data
            $data = [
                'nama_barang' => $request->input('nama_barang'),
                'harga' => $request->input('harga'),
                'deskripsi_barang' => $request->input('deskripsi_barang', ''), // kosong jika desc kosong
                'stok' => $request->input('stok'),
                'berat' => $request->input('berat'),
                'id_umkm' => 1 // test only, id umkm masih static
            ];

            Log::info('Data prepared', ['data' => $data]);

            // pakai guzzle
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

    public function editproduk(Request $request, $id)
    {
        try {
            // Validasi semua input
            $validatedData = $request->validate([
                '*' => 'required' // Semua field harus ada dan tidak boleh kosong
            ]);

            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi.azurewebsites.net/updateproduk/" . $id, $validatedData);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.managebarang')->with('success', 'Produk berhasil diperbarui');
            } else {
                throw new \Exception('Gagal memperbarui produk di API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.managebarang')->with('error', $e->getMessage());
        }
    }

    public function deleteProduk($id)
    {
        try {
            $response = Http::withOptions(['verify' => false])->get("https://umkmapi.azurewebsites.net/produk/" . $id);
            if ($response->successful()) {
                $response = Http::withOptions(["verify" => false])->delete("https://umkmapi.azurewebsites.net/produk/" . $id);
                return redirect()->route("umkm.managebarang")->with("success", "Berhasil meghapus barang");
            } else {
                return back()->with("error", "Barang Tidak ditemukan, gagal menghapus barang");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
