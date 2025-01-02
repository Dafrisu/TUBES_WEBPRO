<?php

namespace App\Http\Controllers;

use Illuminate\Console\View\Components\Component;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DafaController extends Controller
{
    public function getpesananmasuk()
    {
        try {
            $id = session("umkmID");
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id)->json();
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/getpesananmasuk/' . $id);

            if ($response->successful()) {
                $pesananmasuk = $response->json();
                return view('Dafa_kelolaPesanan', compact('pesananmasuk'), compact('profile'));
            } else {
                return view('Dafa_kelolaPesanan')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_kelolaPesanan')->with('error', $e->getMessage());
        }
    }

    public function getpesananditerima()
    {
        try {
            $id = session('umkmID');
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/getpesananditerima/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananditerima = $response->json();

                return view('Dafa_pesananDiterima', compact('pesananditerima'), compact('profile'));
            } else {
                return view('Dafa_pesananDiterima')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_pesananDiterima')->with('error', $e->getMessage());
        }
    }

    public function getpesananditolak()
    {
        try {
            $id = session('umkmID');
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/getpesananditolak/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananditolak = $response->json();

                return view('Dafa_pesananDitolak', compact('pesananditolak'), compact('profile'));
            } else {
                return view('Dafa_pesananDitolak')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_pesananDitolak')->with('error', $e->getMessage());
        }
    }

    public function getpesananselesai()
    {
        try {
            $id = session('umkmID');
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi.azurewebsites.net/getpesananselesai/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananselesai = $response->json();

                return view('Dafa_pesananSelesai', compact('pesananselesai'), compact('profile'));
            } else {
                return view('Dafa_pesananSelesai')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_pesananSelesai')->with('error', $e->getMessage());
        }
    }

    public function updatestatuspesananditerima($id)
    {
        try {

            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi.azurewebsites.net/updatestatuspesananditerima/" . $id);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.kelolapesanan')->with('success', 'Produk Berhasil Diterima');
            } else {
                throw new \Exception('Produk gagal diterima womp womp');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.kelolapesanan')->with('error', $e->getMessage());
        }
    }

    public function updatestatuspesananditolak(Request $request, $id)
    {
        try {
            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi.azurewebsites.net/updatestatuspesananditolak/" . $id, );

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.kelolapesanan')->with('success', 'Produk Telah Ditolak');
            } else {
                throw new \Exception('Produk gagal Ditolak womp womp');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.kelolapesanan')->with('error', $e->getMessage());
        }
    }

    public function editprofileumkm(Request $request, $id)
    {
        $id = session('umkmID');
        try {
            // Validasi semua input
            $validatedData = $request->validate([
                '*' => 'required' // Semua field harus ada dan tidak boleh kosong
            ]);

            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi.azurewebsites.net/updatedataumkm/" . $id, $validatedData);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.dashboard', $id)->with('success', 'Profile Berhasil Di update');
            } else {
                throw new \Exception('Gagal memperbarui Profile di API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.getprofileumkm', $id)->with('error', $e->getMessage());
        }
    }

    public function getprofileumkm($id)
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id);

            if ($respose->successful()) {
                $profile = $respose->json();
                return view('Dafa_editprofile', compact('profile'));
            } else {
                throw new \Exception('Profile tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.getprofileumkm')->with('error', $e->getMessage());
        }
    }

    public function getdashboard()
    {
        $id = session('umkmID');
        try {
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getprofileumkm/' . $id);
            $dataproduklaris = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getdatadashboardproduklaris/' . $id);
            $datapesananmasuk = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getdatadashboardpesananmasuk/' . $id);
            $dataprodukpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getdatadashboardprodukpalingbaru/' . $id);
            $datapesanpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getdatadashboardpesanpalingbaru/' . $id);
            $datacampaignpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/getdatadashboardcampaignpalingbaru/' . $id);

            if ($respose->successful()) {
                $profile = $respose->json();
                $datadashboardproduklaris = json_decode($dataproduklaris, true);
                $datadashboardpesananmasuk = json_decode($datapesananmasuk, true);
                $datadashboardprodukpalingbaru = json_decode($dataprodukpalingbaru, true);
                $datadashboardpesanpalingbaru = json_decode($datapesanpalingbaru, true);
                $datadashboardcampaignpalingbaru = json_decode($datacampaignpalingbaru, true);
                return view('Dafa_Dashboard', compact('profile', 'datadashboardpesananmasuk', 'datadashboardprodukpalingbaru', 'datadashboardpesanpalingbaru', 'datadashboardcampaignpalingbaru'), compact('datadashboardproduklaris'));
            } else {
                throw new \Exception('data tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }
}
