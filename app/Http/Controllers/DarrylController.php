<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DarrylController extends Controller
{
    function daftar(Request $request) {
        try {
            Log::info('Register Attempt', ['data' => $request->all()]);

            $data = [
                'nama_lengkap' => $request->input('namaLengkap'),
                'nomor_telepon' => $request->input('nomorTelepon'),
                'alamat' => $request->input('alamat'),
                'username' => $request->input('username'),
                'email' => $request->input('inputEmail'),
                'password' => $request->input('inputPassword'),
                'nama_usaha' => $request->input('namaUsaha'),
                'NIK_KTP' => $request->input('nikKtp'),
            ];

            Log::info('Data prepared', ['data' => $data]);

            // pakai guzzle
            $client = new Client(['verify' => false]);

            // Send the POST request using Guzzle
            $response = $client->post('https://umkmapi.azurewebsites.net/umkm', [
                'json' => $data,
            ]);

            if ($response->getStatusCode() == 200) {
                return redirect()->route('umkm.masuk')
                    ->with('success', 'Berhasil Mendaftar! (emote mantap)');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal Mendaftar! :(' . $response->getBody());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal total pokoknya dah' . $e->getMessage());
        }
    }

    function masuk(Request $request) {
        try {
            Log::info('Login Attempt', ['data' => $request->all()]);

            $data = [
                'inputEmail' => $request->input('inputEmail'),
                'inputPassword' => $request->input('inputPassword'),
            ];

            Log::info('Data prepared', ['data' => $data]);

            // pakai guzzle
            $client = new Client(['verify' => false]);

            // Send the POST request using Guzzle
            $response = $client->post('https://umkmapi.azurewebsites.net/login', [
                'json' => $data,
            ]);

            // check RememberMe
            $remember = $request->has('RememberMe');
            if ($remember) {
                // isi cookie dengan session yang sudah disimpan kalo RememberMe
                setcookie("LoginEmail", session('LoginEmail'), time()+3600); // set cookie expire sejam
                setcookie("LoginPassword", session('LoginPassword'), time()+3600); // set cookie expire sejam
            } else {
                // Kosongkan cookie kalo tidak RememberMe
                setcookie("LoginEmail", "");
                setcookie("LoginPassword", "");
            }

            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);

                if (isset($responseData['id_umkm'])) {
                    session(['umkmID' => $responseData['id_umkm']]);

                    Log::info('Session created', ['umkmID' => $responseData['id_umkm']]);

                    return redirect()->route('umkm.dashboard')
                        ->with('success', 'Berhasil Masuk! (emote mantap)');
                } else {
                    return redirect()->back()->with('error', 'Gagal Masuk! ID UMKM tidak ditemukan.');
                }
                return redirect()->route('umkm.dashboard')
                    ->with('success', 'Berhasil Masuk! (emote mantap)');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal Masuk! :(' . $response->getBody());
            }
        } catch (\Exception $e) {
            Log::error('Login failed', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal total pokoknya dah' . $e->getMessage());
        }
    }
}
