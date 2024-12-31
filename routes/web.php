<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DafaController;
use App\Http\Controllers\HaikalController;
use App\Http\Controllers\FersyaController;
use App\Http\Controllers\RaphaelMessageController;
use App\Http\Controllers\DarrylController;
use Illuminate\Support\Facades\Http;



Route::view('/', 'darryl_landing')->name('umkm.landing');
Route::view('/masuk', 'darryl_masuk')->name('umkm.masuk');
route::post('/register', [DarrylController::class, 'daftar'])->name('umkm.register');
route::post('/login', [DarrylController::class, 'masuk'])->name('umkm.login');

//Route Punya Dapa
Route::get('/getprofilebar', [DafaController::class, 'getprofilebar'])->name('umkm.dashboard');
Route::get('/kelolapesanan', [DafaController::class, 'getpesananmasuk'])->name('umkm.kelolapesanan');
Route::get('/pesananditerima', [DafaController::class, 'getpesananditerima'])->name('umkm.pesananditerima');
Route::get('/pesananditolak', [DafaController::class, 'getpesananditolak'])->name('umkm.pesananditolak');
Route::get('/pesananselesai', [DafaController::class, 'getpesananselesai'])->name('umkm.pesananselesai');
route::put('/updatestatuspesananditerima/{id}', [DafaController::class, 'updatestatuspesananditerima'])->name('umkm.updatestatuspesananditerima');
route::put('/updatestatuspesananditolak/{id}', [DafaController::class, 'updatestatuspesananditolak'])->name('umkm.updatestatuspesananditolak');
Route::get('/getprofileumkm/{id}', [DafaController::class, 'getprofileumkm'])->name('umkm.getprofileumkm');
route::put('/editprofileumkm/{id}', [DafaController::class, 'editprofileumkm'])->name('umkm.editprofileumkm');
// Route::view('/pesanan_selesai', 'Dafa_pesananSelesai')->name('umkm.pesananselesai');
//End Route Punya Dapa

Route::view('/sidebar', 'Dafa_Sidebar')->name('umkm.sidebar');

Route::view('/inbox_penjual_prioritas', 'fersya_inbox_penjual_prioritas')->name('umkm.inbox_penjual_prioritas');
route::get('/inbox', [FersyaController::class, 'getviewinbox'])->name('umkm.inbox');

route::get('/managebarang', [HaikalController::class, 'getviewproduk'])->name('umkm.managebarang');
route::post('/managebarang', [HaikalController::class, 'addproduk'])->name('umkm.addbarang');
route::get('/updatebarang/{id}', [HaikalController::class, 'getUpdateprodukview'])->name('umkm.viewupdate');
route::put('/updateproduk/{id}', [HaikalController::class, 'editproduk'])->name('umkm.updateproduk');
route::delete('/deleteproduk/{id}', [HaikalController::class, 'deleteProduk'])->name('umkm.deletebarang');
Route::view('/tambahbarang', 'Haikal_PageTambahBarang')->name('umkm.tambahbarang');
Route::get('/proxy/produk', function () {
    $response = Http::withOptions(['verify' => false])->get('https://umkmapi.azurewebsites.net/produk');
    return response($response->body(), $response->status())
        ->header('Content-Type', $response->header('Content-Type')[0]);
});

Route::view('/statistik_penjualan', 'Mahesa_Statistik_Penjualan')->name('umkm.statistik');

// // View routes (removed since they don't need dynamic data passing)
Route::view('/message', 'Raphael_message_penjual')->name('message');
Route::get('/message', [RaphaelMessageController::class, 'showmsgPage'])->name('umkm.message');


// Chat routes for dynamic content
Route::get('/umkm/message', [RaphaelMessageController::class, 'showChatPage'])->name('messagepage');
Route::post('/send-message', [RaphaelMessageController::class, 'sendMessage'])->name('sendMessage');
Route::get('/chat', [RaphaelMessageController::class, 'showChatPage'])->name('chatPage');


//testing sidebar
Route::view('/sidebar', 'Dafa_Sidebar')->name('umkm.sidebar');
