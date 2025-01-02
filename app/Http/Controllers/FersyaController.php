<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


use Illuminate\Support\Facades\Log;

class FersyaController extends Controller
{
    public function getviewinbox()
    {
        try {
            $response = Http::withOptions(['verify' => false,])->get('http://localhost/getinboxpesanan');

            if ($response->successful()) {
                $inbox = $response->json(); // Decode JSON
                return view('fersya_inbox', compact('inbox'));
            } else {
                return view('fersya_inbox')->with('error', 'Gagal mendapatkan inbox dari API');
            }
        } catch (\Exception $e) {
            return view('fersya_inbox')->with('error', $e->getMessage());
        }
    }

    public function getviewcampaign(){
        try {
            // Replace with the correct API endpoint or local database query
            $response = Http::withOptions(['verify' => false,])->get('http://localhost/campaign'); // Example API call
            if ($response->successful()) {
                $campaigns = $response->json(); // Decode JSON
                return view('fersya_inbox', compact('campaigns'));
            } else {
                return view('fersya_inbox')->with('error', 'Gagal mendapatkan Campaign dari API');
            }
        } catch (\Exception $e) {
            return view('fersya_campaigns')->with('error', $e->getMessage());
        }
    }

    public function getUpdateCampaignView($id)
    {   
    try {
        // Check if ID is provided
        if (!$id) {
            throw new \Exception('ID Campaign tidak ditemukan');
        }

        // Call the API to fetch the campaign details
        $response = Http::withOptions(['verify' => false])->get('http://localhost/campaign/{$id}');

        // Check if the API response is successful
        if ($response->successful()) {
            $campaign = $response->json();  // Get the campaign data in JSON format
            return view('update_campaign', compact('campaign'));  // Pass campaign data to the view
        } else {
            throw new \Exception('Tidak menemukan campaign yang dicari');
        }
    } catch (\Exception $e) {
        return redirect()->route('campaigns.index')->with('error', $e->getMessage());
    }
    }

    public function editCampaign(Request $request, $id)
    {
    try {
        // Validate all input fields to ensure they are not empty
        $validatedData = $request->validate([
            '*' => 'required' // All fields must be present and not empty
        ]);

        // Send the data to the API for updating the campaign
        $response = Http::withOptions(['verify' => false])
            ->put("http://localhost/campaign/{$id}" );

        // Check if the API response is successful
        if ($response->successful()) {
            return redirect()->route('campaigns.index')->with('success', 'Campaign berhasil diperbarui');
        } else {
            throw new \Exception('Gagal memperbarui campaign di API');
        }
    } catch (\Exception $e) {
        // Return an error message if something goes wrong
        return redirect()->route('campaigns.index')->with('error', $e->getMessage());
    }
    }

    public function deleteCampaign($id)
{
    try {
        // Send a DELETE request to the local API to delete the campaign
        $response = Http::withOptions(['verify' => false])
            ->delete("http://localhost/Campaign/{$id}" ); // Replace with your local API endpoint

        // Check if the API response is successful
        if ($response->successful()) {
            return redirect()->route('campaigns.index')->with('success', 'Campaign berhasil dihapus');
        } else {
            throw new \Exception('Gagal menghapus campaign di API');
        }
    } catch (\Exception $e) {
        // Return an error message if something goes wrong
        return redirect()->route('campaigns.index')->with('error', $e->getMessage());
    }
}
}
