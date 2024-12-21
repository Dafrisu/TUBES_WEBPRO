<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/landing', 'darryl_landing')->name('umkm.landing');
Route::view('/login', 'darryl_masuk')->name('umkm.login');
Route::view('/sidebar2', 'darryl_sidebar')->name('umkm.sidebar2');

Route::view('/dashboard', 'Dafa_Dashboard')->name('umkm.dashboard');
Route::view('/kelola_pesanan', 'Dafa_kelolaPesanan')->name('umkm.kelolapesanan');
Route::view('/pesanan_diterima', 'Dafa_pesananDiterima')->name('umkm.pesananditerima');
Route::view('/pesanan_ditolak', 'Dafa_pesananDitolak')->name('umkm.pesananditolak');
Route::view('/pesanan_selesai', 'Dafa_pesananSelesai')->name('umkm.pesananselesai');
Route::view('/sidebar', 'Dafa_Sidebar')->name('umkm.sidebar');

Route::view('/inbox_penjual_prioritas', 'fersya_inbox_penjual_prioritas')->name('umkm.inbox_penjual_prioritas');
Route::view('/inbox', 'fersya_inbox')->name('umkm.inbox');

Route::view('/managebarang', 'Haikal_ManageBarang')->name('umkm.managebarang');
Route::view('/tambahbarang', 'Haikal_PageTambahBarang')->name('umkm.tambahbarang');

Route::view('/statistik_penjualan', 'Mahesa_Statistik_Penjualan')->name('umkm.statistik');

Route::view('/chat', 'Raphael_message_chatPage')->name('umkm.chatpage');
Route::view('/message', 'Raphael_message_penjual')->name('umkm.message');
