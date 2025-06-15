<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class produktestingTest extends TestCase
{
    /** @test */
    public function gagal_tambah_produk_kalau_umkmid_kosong()
    {
        $response = $this->post('/managebarang', [
            'nama_barang' => 'Contoh Barang',
            'harga' => 10000,
            'stok' => 10,
            'tipe_barang' => 'makanan',
            'berat' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Terjadi kesalahan: Tidak menemukan ID, silahkan lakukan Login');
    }

    /** @test */
    public function berhasil_tambah_produk_tanpa_gambar()
    {
        Http::fake([
            'https://umkmapi-production.up.railway.app/produk' => Http::response([], 200),
        ]);

        $response = $this
            ->withSession(['umkmID' => 1])
            ->post('managebarang', [
                'nama_barang' => 'Contoh Barang test laravel',
                'harga' => 10000,
                'stok' => 10,
                'tipe_barang' => 'makanan',
                'berat' => 1,
            ]);

        $response->assertRedirect(route('umkm.managebarang'));
        $response->assertSessionHas('success', 'Produk berhasil ditambahkan.');
    }
}
