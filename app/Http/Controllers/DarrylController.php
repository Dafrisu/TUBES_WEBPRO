<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;

class DarrylController extends Controller
{
    function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaLengkap' => 'required|string|min:3',
            'nomorTelepon' => 'required|string|regex:/^[0-9]+$/',
            'alamat' => 'nullable|string',
            'username' => 'required|string|min:3',
            'inputEmail' => 'required|email',
            'inputPassword' => 'required|string|min:6',
            'konfirmasiSandi' => 'required|string|same:inputPassword',
            'namaUsaha' => 'nullable|string',
            'nikKtp' => 'required|numeric|min:10',
        ], [
            'namaLengkap.required' => 'Nama lengkap wajib diisi.',
            'nomorTelepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'inputEmail.email' => 'Email tidak valid.',
            'inputPassword.min' => 'Password minimal 6 karakter.',
            'konfirmasiSandi.same' => 'Konfirmasi sandi tidak sesuai.',
            'nikKtp.min' => 'NIK KTP harus 10 digit.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

            // Pakai guzzle
            $client = new Client(['verify' => false]);

            $response = $client->post('https://umkmapi-production.up.railway.app/api/registrasi-umkm', [
                'json' => $data,
            ]);

            if ($response->getStatusCode() == 201) {
                return redirect()->route('umkm.masuk')
                    ->with('success', 'Berhasil Mendaftar! 🎉');
            } else {
                $error = json_decode($response->getBody(), true)['error'] ?? 'Unknown error';
                return redirect()->back()->with('error', 'Gagal Mendaftar: ' . $error)->withInput();
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $error = json_decode($e->getResponse()->getBody(), true)['error'] ?? $e->getMessage();
            return redirect()->back()->with('error', 'Gagal Mendaftar: ' . $error)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan pendaftaran: ' . $e->getMessage())->withInput();
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
