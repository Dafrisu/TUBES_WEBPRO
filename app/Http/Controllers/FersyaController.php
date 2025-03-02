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
        $id = session('umkmID');
        try {
            $response = Http::withOptions(['verify' => false,])->get('https://umkmkuapi.com/getinboxpesanan');
            $respose = Http::withOptions(['verify' => false])->get('https://umkmkuapi.com/getprofileumkm/' . $id);
            $datacampaign = Http::withOptions(['verify' => false])->get('https://umkmkuapi.com/getcampaign/'. $id);
    
            if ($response->successful()) {
                $inbox = $response->json(); // Decode JSON
                $profile = $respose->json();
                $campaign = json_decode($datacampaign, true);
                return view('fersya_inbox', compact('inbox', 'campaign'), compact('profile'));
            } else {
                return view('fersya_inbox')->with('error', 'Gagal mendapatkan inbox dari API');
            }
    } catch (\Exception $e) {
            return view('fersya_inbox')->with('error', $e->getMessage());
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
        $response = Http::withOptions(['verify' => false])->get('https://umkmkuapi.com/campaign/{$id}');

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

    public function getCampaign($id)
    {
        try {
            if (!$id) {
                throw new \Exception('ID campaign tidak ditemukan');
            }
            $respose = Http::withOptions(['verify' => false])->get('https://umkmkuapi.com/getcampaignbyid/' . $id);

            if ($respose->successful()) {
                $datacampaign = json_decode($respose, true);
                return view('fersya_campaignEdit', compact('datacampaign'));
            } else {
                throw new \Exception('Campaign tidak ditemukan');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.editcampaign', ['id' => session('umkmID')])->with('error', $e->getMessage());

        }
    }

    public function editCampaign(Request $request, $id)
    {
        try {
            $id_umkm = session('umkmID');

            $validatedData = $request->validate([
                '*' => 'required' 
            ]);

            // Kirim data ke API untuk update
            $response = Http::withOptions(['verify' => false])
                ->put("https://umkmkuapi.com/updatecampaign/" . $id_umkm.'/'.$id, $validatedData);

            // Periksa respon API
            if ($response->successful()) {
                return redirect()->route('umkm.inbox', $id)->with('success', 'Campaign Berhasil Di update');
            } else {
                throw new \Exception('Gagal memperbarui Campaign di API');
            }
        } catch (\Exception $e) {
            return redirect()->route('umkm.inbox', $id)->with('error', $e->getMessage());
        }
    }

    public function addCampaign(Request $request)
{
    try {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date',
            'image_url' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', 
        ]);

        
        $validatedData['id_umkm'] = session('umkmID');


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $validatedData['image'] = base64_encode(file_get_contents($file->getRealPath())); 
        }

        $response = Http::withOptions(['verify' => false])
            ->post('https://umkmkuapi.com/campaign', $validatedData); 

        
        if ($response->successful()) {
            return redirect()->route('umkm.inbox')->with('success', 'Campaign berhasil ditambahkan');
        } else {
            throw new \Exception('Gagal menambahkan Campaign ke API');
        }
    } catch (\Exception $e) {
        
        return redirect()->back()->withInput()->with('error', $e->getMessage());
    }
}


    public function deleteCampaign($id)
{
    try {
        // Send a DELETE request to the local API to delete the campaign
        $response = Http::withOptions(['verify' => false])
            ->delete("https://umkmkuapi.com/Campaign/{$id}" ); // Replace with your local API endpoint


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
