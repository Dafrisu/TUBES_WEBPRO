<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;

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
            return redirect()->back()->with('error', 'Gagal melakukan pendaftaran' . $e->getMessage());
        }
    }

    function masuk(Request $request)
    {
        try {
            $data = [
                'inputEmail' => $request->input('inputEmail'),
                'inputPassword' => $request->input('inputPassword'),
            ];

            $client = new Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/login', [
                'json' => $data,
            ]);

            // check RememberMe
            $remember = $request->has('RememberMe');
            Cookie::queue(Cookie::make('LoginEmail', $remember ? $data['inputEmail'] : '', 60));
            Cookie::queue(Cookie::make('LoginPassword', $remember ? $data['inputPassword'] : '', 60));

            // jika error di bagian API
            if ($response->getStatusCode() !== 200) {
                return back()->with('error', 'Gagal Masuk! (code error)');
            }

            $responseData = json_decode($response->getBody(), true);

            // Jika id_umkm tidak ditemukan (user tidak terdaftar)
            if (!isset($responseData['id_umkm'])) {
                return back()->with('error', 'Gagal Masuk! ID UMKM tidak ditemukan.');
            }

            session(['umkmID' => $responseData['id_umkm']]);
            return redirect()->route('umkm.dashboard')->with('success', 'Berhasil Masuk! 👍👍');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan! Masukan data yang sesuai!');
        }
    }

    function resetPassword(Request $request)
    {
        try {
            $request->validate(['inputEmail' => 'required|email']);

            // pakai guzzle
            $client = new Client(['verify' => false]);

            // Send the POST request using Guzzle
            $response = $client->post('https://umkmapi-production.up.railway.app/reset-password', [
                'json' => [
                    'email' => $request->input('inputEmail')
                ]
            ]);

            $body = json_decode((string) $response->getBody(), true);

            if (isset($body['message'])) {
                return back()->with('status', $body['message']);
            } else {
                return back()->withErrors(['email' => 'Failed to send reset link']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal verifikasi akun anda');
        }
    }

    function newPassword(Request $request)
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
