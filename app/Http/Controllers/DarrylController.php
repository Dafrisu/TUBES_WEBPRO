<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class DarrylController extends Controller
{
    function daftar(Request $request)
    {
        try {
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
            // pakai guzzle
            $client = new Client(['verify' => false]);

            // POST request Guzzle
            $response = $client->post('https://umkmapi-production.up.railway.app/umkm', [
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

    function masuk(Request $request)
    {
        try {
            $data = [
                'inputEmail' => $request->input('inputEmail'),
                'inputPassword' => $request->input('inputPassword'),
            ];

            Log::info('Data prepared', ['data' => $data]);
            // pakai guzzle
            $client = new Client(['verify' => false]);

            // Send the POST request using Guzzle
            $response = $client->post('https://umkmapi-production.up.railway.app/login', [
                'json' => $data,
            ]);

            // check RememberMe
            $remember = $request->has('RememberMe');
            if ($remember) {
                // isi cookie dengan session yang sudah disimpan kalo RememberMe
                Cookie::queue(Cookie::make('LoginEmail', $request->input('inputEmail'), 60)); // set cookie expire sejam
                Cookie::queue(Cookie::make('LoginPassword', $request->input('inputPassword'), 60)); // set cookie expire sejam
            } else {
                // Kosongkan cookie kalo tidak RememberMe
                Cookie::expire('LoginEmail');
                Cookie::expire('LoginPassword');
            }

            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);

                if (isset($responseData['id_umkm'])) {
                    session(['umkmID' => $responseData['id_umkm']]);

                    return redirect()->route('umkm.dashboard')
                        ->with('success', 'Berhasil Masuk! 👍👍');
                } else {
                    return redirect()->back()->with('error', 'Gagal Masuk! ID UMKM tidak ditemukan.');
                }
                return redirect()->route('umkm.dashboard')
                    ->with('success', 'Berhasil Masuk! 👍👍');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal Masuk! :(' . $response->getBody());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal total pokoknya dah');
        }
    }

    function resetPassword(Request $request)
    {
        try {
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal verifikasi akun anda');
        }
    }

    function auth(Request $request)
    {
        try {
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal verifikasi akun anda');
        }
    }

    function generateCode(Request $request)
    {
        try {
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal kirim ulang code');
        }
    }
}