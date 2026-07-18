<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/', 'dashboard.index')->name('dashboard');

Route::view('/master-pegawai', 'master-pegawai.index')->name('master-pegawai');

Route::view('/iki', 'iki.index')->name('iki');
Route::view('/jakin', 'jakin.index')->name('jakin');
Route::view('/renaksi', 'renaksi.index')->name('renaksi');
Route::view('/lapkin', 'lapkin.index')->name('lapkin');

Route::view('/rekap-dokumen', 'rekap-dokumen.index')->name('rekap-dokumen');