<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
            $remember = $request->has('RememberMe');
            if ($remember) {
                Cookie::queue(Cookie::make('LoginEmail', $data['email'], 60, null, null, true, true, false, 'Strict'));
                Cookie::queue(Cookie::make('LoginPassword', $data['password'], 60, null, null, true, true, false, 'Strict'));
            } else {
                // Clear cookies if RememberMe is not checked
                Cookie::queue(Cookie::forget('LoginEmail'));
                Cookie::queue(Cookie::forget('LoginPassword'));
            }

            // untuk simpan email user ketika terjadi kesalahan pada saat input form
            session()->flash('inputEmail', $data['email']);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('API Response from masuk-umkm:', [
                'status' => $response->getStatusCode(),
                'body' => $result
            ]);

            // simpan id_umkm dan status verified dari response API
            $id_umkm = $result['id_umkm'] ?? null;

            // cek is_verified untuk menentukan apakah harus 2fa atau tidak
            $is_verified = $result['is_verified'] ?? null;

            Log::info('API Response:', $result);
            Log::info('API Response from UMKM server:', $result);

            // simpan id_umkm and email untuk page otp
            session([
                'umkmID' => $result['id_umkm'],
                'email' => $data['email'],
                'is_verified' => $is_verified,
            ]);

            // langsung ke dashboard jika is_verified == 1 (true)
            if ($is_verified) {
                Log::info('User is verified, redirecting to dashboard', [
                    'id_umkm' => $id_umkm,
                    'email' => $data['email']
                ]);
                return redirect()->route('umkm.dashboard')->with('success', 'Login berhasil.');
            }

            Log::info('User is not verified, redirecting to OTP', [
                'id_umkm' => $id_umkm,
                'email' => $data['email']
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

    function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputEmail' => 'required|email',
            'token' => 'required|string',
            'inputPassword' => 'required|string|min:6|confirmed',
        ], [
            'inputEmail.required' => 'Email wajib diisi.',
            'inputEmail.email' => 'Email tidak valid.',
            'token.required' => 'Token wajib diisi.',
            'inputPassword.required' => 'Kata sandi wajib diisi.',
            'inputPassword.min' => 'Kata sandi minimal 6 karakter.',
            'inputPassword.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if ($validator->fails()) {
            Log::warning('Reset Password Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'email' => strtolower($request->input('inputEmail')),
                'token' => $request->input('token'),
                'password' => $request->input('inputPassword'),
            ];

            Log::info('Reset Password Data:', $data);

            $client = new Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/api/reset-password', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'LaravelApp',
                ],
                'json' => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Reset Password API Response:', [
                'status' => $response->getStatusCode(),
                'body' => $result
            ]);

            session()->flush();
            return redirect()->route('umkm.masuk')->with('success', 'Kata sandi berhasil direset. Silakan login.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true)['error'] ?? $e->getMessage() : 'Tidak dapat terhubung ke server';
            Log::error('Reset Password RequestException: ' . $error, [
                'status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null,
                'response_body' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ]);
            return redirect()->back()->with('error', $error)->withInput();
        } catch (\Exception $e) {
            Log::error('Reset Password Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mereset kata sandi: ' . $e->getMessage())->withInput();
        }
    }

    public function lupaPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputEmail' => 'required|email',
        ], [
            'inputEmail.required' => 'Email wajib diisi.',
            'inputEmail.email' => 'Email tidak valid.',
        ]);

        if ($validator->fails()) {
            Log::warning('Forgot Password Validation failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $email = strtolower($request->input('inputEmail'));

            Log::info('Forgot Password Request:', ['email' => $email]);

            $client = new Client(['verify' => false]);
            $response = $client->post('https://umkmapi-production.up.railway.app/api/forgot-password', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'LaravelApp',
                ],
                'json' => [
                    'email' => $email,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Forgot Password API Response:', [
                'status' => $response->getStatusCode(),
                'body' => $result
            ]);

            return redirect()->route('umkm.lupa-password')->with('status', 'Link reset kata sandi telah dikirim ke email Anda.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $error = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true)['error'] ?? $e->getMessage() : 'Tidak dapat terhubung ke server';
            Log::error('Forgot Password RequestException: ' . $error, [
                'status' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : null,
                'response_body' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ]);
            return redirect()->back()->with('error', $error)->withInput();
        } catch (\Exception $e) {
            Log::error('Forgot Password Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function logout(Request $request)
    {
        session()->flush(); // clear session data

        // forget cookie
        Cookie::queue(Cookie::forget('LoginEmail'));
        Cookie::queue(Cookie::forget('LoginPassword'));

        return redirect()->route('umkm.masuk');
    }

    // Show reset password form
    public function showResetPasswordForm(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        if (!$email || !$token) {
            return redirect()->route('umkm.lupa-password')->with('error', 'Link reset tidak valid.');
        }

        return view('umkm.reset-password', compact('email', 'token'));
    }
}
