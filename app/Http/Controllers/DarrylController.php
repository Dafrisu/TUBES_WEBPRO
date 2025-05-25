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
        $validator = Validator::make($request->all(), [
            'inputEmail' => 'required|email',
            'inputPassword' => 'required|string|min:6',
        ], [
            'inputEmail.required' => 'Email wajib diisi.',
            'inputEmail.email' => 'Email tidak valid.',
            'inputPassword.required' => 'Kata sandi wajib diisi.',
            'inputPassword.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'email' => strtolower($request->input('inputEmail')),
                'password' => $request->input('inputPassword'),
            ];

            Log::info('UMKM Login Data:', $data);

            Log::info('JSON Payload to API:', $data);
            $client = new Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/api/masuk-umkm', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'LaravelApp',
                ],
                'json' => $data,
            ]);

            // check RememberMe
            // $remember = $request->has('RememberMe');
            // Cookie::queue(Cookie::make('LoginEmail', $remember ? $data['inputEmail'] : '', 60));
            // Cookie::queue(Cookie::make('LoginPassword', $remember ? $data['inputPassword'] : '', 60));

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('API Response:', $result);
            Log::info('API Response from UMKM server:', $result);

            // simpan id_umkm and email untuk page otp
            session([
                'id_umkm' => $result['id_umkm'],
                'email' => $data['email'],
            ]);

            return redirect()->route('umkm.auth')->with('success', 'OTP telah dikirim ke email Anda.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true)['error'] ?? $e->getMessage() : 'Tidak dapat terhubung ke server';
            Log::error('UMKM Login RequestException: ' . $error, ['status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null]);
            Log::error('Guzzle Exception:', [
                'message' => $e->getMessage(),
                'request' => (string) $e->getRequest()->getBody(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ]);
            return redirect()->back()->with('error', $error)->withInput();
        } catch (\Exception $e) {
            Log::error('UMKM Login Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage())->withInput();
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

    function kirimCode(Request $request)
    {
        try {
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal kirim ulang code');
        }
    }
}
