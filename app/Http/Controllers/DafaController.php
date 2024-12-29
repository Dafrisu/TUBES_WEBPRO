<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class DafaController extends Controller
{
    public function getpesananmasuk()
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('localhost/getpesananmasuk');

            if ($response->successful()) {
                $pesananmasuk = $response->json();
                return view('Dafa_kelolaPesanan', compact('pesananmasuk'));
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
            $response = Http::withOptions(['verify' => false,])->get('localhost/getpesananditerima');

            if ($response->successful()) {
                $pesananditerima = $response->json();

                return view('Dafa_pesananDiterima', compact('pesananditerima'));
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
            $response = Http::withOptions(['verify' => false,])->get('localhost/getpesananditolak');

            if ($response->successful()) {
                $pesananditolak = $response->json();

                return view('Dafa_pesananDitolak', compact('pesananditolak'));
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
            $response = Http::withOptions(['verify' => false,])->get('localhost/getpesananselesai');

            if ($response->successful()) {
                $pesananselesai = $response->json();

                return view('Dafa_pesananSelesai', compact('pesananselesai'));
            } else {
                return view('Dafa_pesananSelesai')->with('error', 'Gagal mendapatkan data pesanan dari API');
            }
        } catch (\Exception $e) {
            return view('Dafa_pesananSelesai')->with('error', $e->getMessage());
        }
    }
}