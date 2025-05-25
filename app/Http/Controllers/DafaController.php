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
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananmasuk/' . $id);

            if ($response->successful()) {
                $pesananmasuk = $response->json();
                return view('Dafa_kelolaPesanan', compact('pesananmasuk'), compact('profile'));
            } else {
                return view('umkm.dashboard')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getpesananditerima()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananditerima/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananditerima = $response->json();

                return view('Dafa_pesananDiterima', compact('pesananditerima'), compact('profile'));
            } else {
                return view('umkm.dashboard')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getpesananditolak()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananditolak/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananditolak = $response->json();

                return view('Dafa_pesananDitolak', compact('pesananditolak'), compact('profile'));
            } else {
                return view('umkm.dashboard')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getpesananselesai()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananselesai/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
            if ($response->successful()) {
                $pesananselesai = $response->json();

                return view('Dafa_pesananSelesai', compact('pesananselesai'), compact('profile'));
            } else {
                return view('umkm.dashboard')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function updatestatuspesananditerima($id_batch)
    {

        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatestatuspesananditerima/" . $id . '/' . $id_batch);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.kelolapesanan')->with('success', 'Produk Berhasil Diterima');
            } else {
                return redirect()->route('umkm.kelolapesanan')->with('error', 'Produk Gagal Diterima');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function updatestatuspesananditolak($id_batch)
    {
        try {
            // Kirim data ke API untuk update
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatestatuspesananditolak/" . $id . '/' . $id_batch);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.kelolapesanan')->with('success', 'Produk Telah Ditolak');
            } else {
                return redirect()->route('umkm.kelolapesanan')->with('error', 'Produk Gagal Ditolak');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function editprofileumkm(Request $request)
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:15',
                'alamat' => 'required|string|max:255',
                'username' => 'required|string|max:50',
                'email' => 'required|email|max:255',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*?&]/',
                ],
                'nama_usaha' => 'required|string|max:255',
                'NIK_KTP' => 'required|string|max:20'
            ]);

            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatedataumkm/" . $id, $validatedData);

            if ($response->successful()) {
                return redirect()->route('umkm.dashboard', $id)->with('success', 'Profile Berhasil Di update');
            } else {
                return redirect()->route('umkm.getprofileumkm', $id)->with('error', 'Profile Gagal Di update');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk', $id)->with('error', $e->getMessage());
        }
    }

    public function getprofileumkm()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id);

            if ($respose->successful()) {
                $profile = $respose->json();
                return view('Dafa_editprofile', compact('profile'));
            } else {
                return redirect()->route('umkm.dashboard')->with('error', 'gagal get profile');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getdatakurir()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdaftarkurir/' . $id);
            if ($respose->successful()) {
                $datakurir = $respose->json();
                return view('Dafa_konfirmasiKurir', compact('datakurir'));
            } else {
                return redirect()->route('umkm.dashboard')->with('error', 'catch error');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getumkmkurir()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getumkmkurir/' . $id);

            if ($respose->successful()) {
                $datakurir = $respose->json();
                return view('Dafa_pecatKurir', compact('datakurir'));
            } else {
                return redirect()->route('umkm.dashboard')->with('error', 'catch error');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function gethistorykurirumkm()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/gethistorykurirumkm/' . $id);

            if ($respose->successful()) {
                $datakurir = $respose->json();
                return view('Dafa_historyKurir', compact('datakurir'));
            } else {
                return redirect()->route('umkm.dashboard')->with('error', 'Error fetching data kurir');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function terimakurir($id_kurir)
    {

        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("localhost/updateStatusKurirTerdaftar/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.konfimasiKurir')->with('success', 'Kurir telah diterima');
            } else {
                return redirect()->route('umkm.konfimasiKurir')->with('error', 'Kurir gagal diterima');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function tolakKurir($id_kurir)
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            // Kirim data ke API untuk update
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updateStatusKurirDitolak/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.konfimasiKurir')->with('success', 'Kurir telah ditolak');
            } else {
                return redirect()->route('umkm.konfimasiKurir')->with('error', 'Kurir gagal ditolak');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function deleteKurir($id_kurir)
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updateStatusKurirDipecat/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.getumkmkurir')->with('success', 'Kurir telah dipecat');
            } else {
                return redirect()->route('umkm.getumkmkurir')->with('error', 'Kurir gagal dipecat');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.masuk')->with('error', $e->getMessage());
        }
    }

    public function getdashboard()
    {
        try {
            $id = session('umkmID');
            if (!$id) {
                throw new \Exception('ID profile tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id);
            $dataproduklaris = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdatadashboardproduklaris/' . $id);
            $datapesananmasuk = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdatadashboardpesananmasuk/' . $id);
            $dataprodukpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdatadashboardprodukpalingbaru/' . $id);
            $datapesanpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdatadashboardpesanpalingbaru/' . $id);
            $datacampaignpalingbaru = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getdatadashboardcampaignpalingbaru/' . $id);

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
