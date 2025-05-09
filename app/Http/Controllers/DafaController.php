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
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananmasuk/' . $id);

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
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananditerima/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
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
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananditolak/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
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
            $response = Http::withOptions(['verify' => false,])->get('https://umkmapi-production.up.railway.app/getpesananselesai/' . $id);
            $profile = Http::withOptions(['verify' => false])->get('https://umkmapi-production.up.railway.app/getprofileumkm/' . $id)->json();
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

    public function updatestatuspesananditerima($id_batch)
    {

        try {
            $id_umkm = session('umkmID');
            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatestatuspesananditerima/" . $id_umkm . '/' . $id_batch);

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

    public function updatestatuspesananditolak($id_batch)
    {
        $id_umkm = session('umkmID');
        try {
            // Kirim data ke API untuk update
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatestatuspesananditolak/" . $id_umkm . '/' . $id_batch);

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

    public function editprofileumkm(Request $request)
    {
        try {

            $id = session('umkmID');
            // Validasi semua input
            $validatedData = $request->validate([
                'nama_lengkap' => '', // Semua field harus ada dan tidak boleh kosong
                'nomor_telepon' => '', // Semua field harus ada dan tidak boleh kosong
                'alamat' => '', // Semua field harus ada dan tidak boleh kosong
                'username' => '', // Semua field harus ada dan tidak boleh kosong
                'email' => '', // Semua field harus ada dan tidak boleh kosong
                'password' => '', // Semua field harus ada dan tidak boleh kosong
                'nama_usaha' => '', // Semua field harus ada dan tidak boleh kosong
                'NIK_KTP' => '' // Semua field harus ada dan tidak boleh kosong
            ]);

            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updatedataumkm/" . $id, $validatedData);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.dashboard', $id)->with('success', 'Profile Berhasil Di update');
            } else {
                throw new \Exception('Gagal memperbarui Profile di API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard', $id)->with('error', $e->getMessage());
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
                throw new \Exception('Profile tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.getprofileumkm')->with('error', $e->getMessage());
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
                throw new \Exception('Data kurir tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
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
                throw new \Exception('Data kurir tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
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
                throw new \Exception('Data kurir tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.dashboard')->with('error', $e->getMessage());
        }
    }

    public function terimakurir($id_kurir)
    {
        $id_umkm = session('umkmID');
        try {
            // Kirim data ke API untuk update
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updateStatusKurirTerdaftar/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.konfimasiKurir')->with('success', 'Kurir telah diterima');
            } else {
                throw new \Exception('Kurir gagal diterima womp womp');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.konfirmasiKurir')->with('error', $e->getMessage());
        }
    }

    public function tolakKurir($id_kurir)
    {
        $id_umkm = session('umkmID');
        try {
            // Kirim data ke API untuk update
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updateStatusKurirDitolak/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.konfimasiKurir')->with('success', 'Kurir telah ditolak');
            } else {
                throw new \Exception('Kurir gagal ditolak womp womp');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.konfirmasiKurir')->with('error', $e->getMessage());
        }
    }

    public function deleteKurir($id_kurir)
    {
        $id_umkm = session('umkmID');
        try {
            // Kirim data ke API untuk update
            $id_umkm = session('umkmID');
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmapi-production.up.railway.app/updateStatusKurirDipecat/" . $id_kurir);
            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm_')->with('success', 'Kurir telah dipecat');
            } else {
                throw new \Exception('Kurir gagal dipecat womp womp');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.getumkmkurir')->with('error', $e->getMessage());
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