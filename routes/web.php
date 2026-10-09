<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fauzan', function () {
    return 'Halo, selamat datang di laravel 13';
});

Route::get('/waktu', fn () => now()->format('d-m-Y H:i:s'));

// Parameter wajib
Route::get('/profil/{nama}', function (string $nama) {
    return "Halo, selamat datang, {$nama}";
});

// Parameter opsional dengan nilai default
Route::get('/kategori/{nama?}', function (?string $nama = 'semua') {
    return "Menampilkan kategori : {$nama}";
});

// Lebih dari satu parameter
Route::get('/kelas/{kode}/{nim}', function (string $kode, string $nim) {
    return "Kelas {$kode}, NIM {$nim}";
});

// Pembatasan parameter (constraint)
Route::get('/artikel/{id}', function (int $id) {
    return "Artikel nomor {$id}";
})->whereNumber('id');

Route::get('/pengguna/{username}', function (string $username) {
    return "Pengguna: {$username}";
})->whereAlpha('username');

Route::get('/kode/{kode}', function (string $kode) {
    return "Kode: {$kode}";
})->where('kode', '[A-Z]{3}[0-9]{2}');

// Route langsung ke view dan named route
// Route::view tidak memerlukan closure
Route::view('/tentang', 'tentang')->name('tentang');

Route::get('/kontak', function () {
    return view('kontak', ['email' => 'info@kampus.ac.id']);
})->name('kontak');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => 'Dashboard Admin')
        ->name('dashboard'); // URL: /admin/dashboard, nama: admin.dashboard

    Route::get('/pengaturan', fn () => 'Pengaturan Admin')
        ->name('pengaturan'); // URL: /admin/pengaturan, nama: admin.pengaturan
});

Route::redirect('/beranda', '/');

// Dieksekusi bila tidak ada rute yang cocok (letakkan paling bawah)
Route::fallback(function () {
    return response('Halaman tidak ditemukan (kustom).', 404);
});