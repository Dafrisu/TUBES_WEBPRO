<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahesaController extends Controller
{
    public function getDailyStats(Request $request)
    {
        try {
            $id = session('umkmID');
            $month = $request->query('month');
            $year = $request->query('year');

            $response = Http::withOptions(['verify' => false])
                ->get("https://umkmapi-production.up.railway.app/daily-stats/{$id}", [
                    'month' => $month,
                    'year' => $year
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => 'Gagal mendapatkan data harian',
                    'details' => $response->json() ?? $response->status()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getYearlyStats(Request $request)
    {
        try {
            $id = session('umkmID');
            $year = $request->query('year', date('Y'));

            $response = Http::withOptions(['verify' => false])
                ->get("https://umkmapi-production.up.railway.app/monthly-stats/{$id}", [
                    'year' => $year
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => 'Gagal mendapatkan data tahunan',
                    'details' => $response->json() ?? $response->status()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}