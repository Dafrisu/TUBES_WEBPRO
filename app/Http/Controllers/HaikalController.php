<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


use Illuminate\Support\Facades\Log;

class HaikalController extends Controller
{

    public function getmodal($id)
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/Produk/' . $id);
            if ($response->successful()) {
                $produkbyID = $response->json();
                return response()->json($produkbyID);
            }
        } catch (\Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

    public function searchproduk(Request $request)
    {
        $input = $request->query('search');
        $id_umkm = session('umkmID');
        try {
            $response = Http::withOptions(['verify' => false])
                ->get("https://umkmapi-production.up.railway.app/search/{$id_umkm}?search=" . urlencode($input));

            $produk = $response->json();

            return view('partials.tabelproduk', ['produk' => $produk]);
        } catch (\exception $e) {
            return response("<tr><td colspan='7' class='text-center text-danger'>Gagal: {$e->getMessage()}</td></tr>");
        }
    }

    public function getviewproduk()
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/produkumkm/' . session('umkmID'));

            if ($response->successful()) {
                $produk = $response->json(); // Decode JSON
                $produkmakanan = array_filter($produk, fn($item) => $item["tipe_barang"] === "Makanan");
                $produkminuman = array_filter($produk, fn($item) => $item["tipe_barang"] === "Minuman");
                return view('Haikal_managebarang', compact('produk', 'produkmakanan', 'produkminuman'));
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

            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/Produk/' . $id);
            if ($respose->successful()) {
                $produk = $respose->json();
                return view('Haikal_pageUpdatebarang', compact('produk'));
            } else {
                throw new \Exception('Tidak menemukan barang yang dicari');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.managebarang')->with('error', $e->getMessage());
        }
    }

    public function addproduk(Request $request)
    {
        try {
            $uploadResult = null;
            Log::info('addproduk called', ['data' => $request->all()]);

            // Pakai guzzle
            $client = new Client(['verify' => false]);

            // Validasi input
            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'stok' => 'required|integer',
                'tipe_barang' => 'required|string',
                'berat' => 'required|numeric',
                'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validasi file gambar
            ]);



            // Cek jika ada file gambar yang diunggah
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $file = $request->file('foto');

                $uploadResponse = $client->post('https://umkmapi-production.up.railway.app/uploadfile', [
                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => fopen($file->getPathname(), 'r'),
                            'filename' => $file->getClientOriginalName(),
                        ],
                    ],
                ]);

                $responseBody = json_decode($uploadResponse->getBody(), true);
                if ($uploadResponse && isset($responseBody['url'])) {
                    $uploadResult = ['url' => $responseBody['url']];
                } else {
                    return redirect()->back()->with('error', 'gagal menambahkan gambar');
                }

                Log::info('upload result:', $uploadResult);
            } else {
                $uploadResult = ['url' => "https://umkmkuapi.com/default_product.jpeg"];
            }

            $data = [
                'nama_barang' => $request->input('nama_barang'),
                'harga' => $request->input('harga'),
                'deskripsi_barang' => $request->input('deskripsi_barang', ''),
                'stok' => $request->input('stok'),
                'tipe_barang' => $request->input('tipe_barang'),
                'image_url' => $uploadResult['url'],
                'berat' => $request->input('berat'),
                'id_umkm' => session('umkmID'),
            ];

            // Kirim data ke API
            $response = $client->post('https://umkmapi-production.up.railway.app/produk', [
                'json' => $data,
            ]);

            // Cek respons API
            if ($response->getStatusCode() == 200) {
                return redirect()->route('umkm.managebarang')
                    ->with('success', 'Produk berhasil ditambahkan.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal menambahkan produk: ' . $response->getBody());
            }
        } catch (\Exception $e) {
            // Tangani kesalahan
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
                ->put("https://umkmapi-production.up.railway.app/updateproduk/" . $id, $validatedData);

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
            $response = Http::withOptions(['verify' => false])->get("https://umkmapi-production.up.railway.app/produk/" . $id);
            if ($response->successful()) {
                $response = Http::withOptions(["verify" => false])->delete("https://umkmapi-production.up.railway.app/produk/" . $id);
                return redirect()->route("umkm.managebarang")->with("success", "Berhasil meghapus barang");
            } else {
                return back()->with("error", "Barang Tidak ditemukan, gagal menghapus barang");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
