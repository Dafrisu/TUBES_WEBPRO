<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MahesaController extends Controller
{
    public function getDailyStats(Request $request)
    {
        try {
            $id = session('umkmID');
            $month = $request->query('month');
            $year = $request->query('year');

            $response = Http::withOptions(['verify' => false])
                ->get("https://umkmkuapi.com/daily-stats/{$id}?month={$month}&year={$year}");

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Gagal mendapatkan data harian'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getYearlyStats()
    {
        try {
            $id = session('umkmID');

            $response = Http::withOptions(['verify' => false])
                ->get("https://umkmkuapi.com/monthly-stats/{$id}");

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Gagal mendapatkan data tahunan'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}