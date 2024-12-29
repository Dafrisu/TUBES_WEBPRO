<?php

use App\Http\Controllers\DafaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HaikalController;


Route::view('/', 'darryl_landing')->name('umkm.landing');
Route::view('/masuk', 'darryl_masuk')->name('umkm.masuk');
Route::view('/sidebar2', 'darryl_sidebar')->name('umkm.sidebar2');

Route::view('/dashboard', 'Dafa_Dashboard')->name('umkm.dashboard');
Route::get('/kelolapesanan', [DafaController::class, 'getpesananmasuk'])->name('umkm.kelolapesanan');
Route::view('/pesanan_diterima', 'Dafa_pesananDiterima')->name('umkm.pesananditerima');
Route::view('/pesanan_ditolak', 'Dafa_pesananDitolak')->name('umkm.pesananditolak');
Route::view('/pesanan_selesai', 'Dafa_pesananSelesai')->name('umkm.pesananselesai');
Route::view('/sidebar', 'Dafa_Sidebar')->name('umkm.sidebar');

Route::view('/inbox_penjual_prioritas', 'fersya_inbox_penjual_prioritas')->name('umkm.inbox_penjual_prioritas');
Route::view('/inbox', 'fersya_inbox')->name('umkm.inbox');

route::get('/managebarang', [HaikalController::class, 'getviewproduk'])->name('umkm.managebarang');
route::post('/managebarang', [HaikalController::class, 'addproduk'])->name('umkm.addbarang');
route::get('/updatebarang/{id}', [HaikalController::class, 'getUpdateprodukview'])->name('umkm.viewupdate');
route::put('/updateproduk/{id}', [HaikalController::class, 'editproduk'])->name('umkm.updateproduk');
route::delete('/deleteproduk/{id}', [HaikalController::class, 'deleteProduk'])->name('umkm.deletebarang');
Route::view('/tambahbarang', 'Haikal_PageTambahBarang')->name('umkm.tambahbarang');

Route::view('/statistik_penjualan', 'Mahesa_Statistik_Penjualan')->name('umkm.statistik');

Route::view('/chat', 'Raphael_message_chatPage')->name('umkm.chatpage');
Route::view('/message', 'Raphael_message_penjual')->name('umkm.message');
