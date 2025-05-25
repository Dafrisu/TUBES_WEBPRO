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
                'umkmID' => $result['id_umkm'],
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

    public function verifikasiOTP(Request $request)
    {
        $action = $request->input('action');

        if ($action === 'kirim-ulang') {
            return $this->kirimCode($request);
        }

        // Log session data
        Log::info('Session Data in verifikasiOTP:', [
            'email' => session('email'),
            'id_umkm' => session('id_umkm')
        ]);

        $validator = Validator::make($request->all(), [
            'inputEmail' => 'required|email',
            'inputOtp' => 'required|string',
        ], [
            'inputEmail.required' => 'Email wajib diisi.',
            'inputEmail.email' => 'Email tidak valid.',
            'inputOtp.required' => 'Kode OTP wajib diisi.',
        ]);

        if ($validator->fails()) {
            Log::warning('OTP Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'email' => strtolower($request->input('inputEmail')),
                'otp' => $request->input('inputOtp'),
            ];

            Log::info('OTP Verification Data:', $data);

            // Ensure session email matches form email
            if (strtolower($request->input('inputEmail')) !== session('email')) {
                Log::warning('Email mismatch', [
                    'form_email' => $request->input('inputEmail'),
                    'session_email' => session('email')
                ]);
                return redirect()->back()->with('error', 'Email tidak sesuai dengan sesi login.')->withInput();
            }

            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/api/verifikasi-otp', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'LaravelApp',
                ],
                'json' => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('API Response from verifikasi-otp:', [
                'status' => $response->getStatusCode(),
                'body' => $result
            ]);

            // Store verification status
            session(['is_verified' => true]);

            return redirect()->route('umkm.dashboard')->with('success', 'Verifikasi OTP berhasil.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true)['error'] ?? $e->getMessage() : 'Tidak dapat terhubung ke server';
            Log::error('OTP Verification RequestException:', [
                'error' => $error,
                'status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null,
                'response_body' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ]);
            if ($error === 'ID profile tidak ditemukan') {
                return redirect()->route('umkm.login')->with('error', 'ID profile tidak ditemukan. Silakan login ulang.');
            }
            return redirect()->back()->with('error', $error)->withInput();
        } catch (\Exception $e) {
            Log::error('OTP Verification Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memverifikasi OTP: ' . $e->getMessage())->withInput();
        }
    }

    function kirimCode(Request $request)
    {
        try {
            $email = session('email');
            $id_umkm = session('id_umkm');

            if (!$email || !$id_umkm) {
                Log::warning('Invalid session for OTP resend', ['email' => $email, 'id_umkm' => $id_umkm]);
                return redirect()->back()->with('error', 'Sesi tidak valid. Silakan login ulang.');
            }

            $client = new Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/api/kirim-ulang-otp', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'LaravelApp',
                ],
                'json' => ['email' => $email, 'id_umkm' => $id_umkm],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Resend OTP Response:', $result);

            return redirect()->back()->with('success', 'OTP telah dikirim ulang ke email Anda.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true)['error'] ?? $e->getMessage() : 'Tidak dapat terhubung ke server';
            Log::error('Resend OTP RequestException: ' . $error);
            return redirect()->back()->with('error', 'Gagal mengirim ulang OTP: ' . $error);
        } catch (\Exception $e) {
            Log::error('Resend OTP Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim ulang OTP: ' . $e->getMessage());
        }
    }
}
