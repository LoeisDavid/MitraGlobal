<?php

use App\Http\Controllers\Kategori;
use App\Http\Controllers\Merk;
use App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Barang;
use App\Http\Controllers\Nota;
use App\Http\Controllers\NotaBarang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Barang;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [Kategori::class, 'index'])->name('index');
    Route::get('/create', [Kategori::class, 'create'])->name('create');
    Route::post('/store', [Kategori::class, 'store'])->name('store');
    Route::get('/{id}/edit', [Kategori::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [Kategori::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [Kategori::class, 'destroy'])->name('destroy');
});

Route::prefix('merk')->name('merk.')->group(function () {
    Route::get('/', [Merk::class, 'index'])->name('index');
    Route::get('/create', [Merk::class, 'create'])->name('create');
    Route::post('/store', [Merk::class, 'store'])->name('store');
    Route::get('/{id}/edit', [Merk::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [Merk::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [Merk::class, 'destroy'])->name('destroy');
});

Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/', [Pelanggan::class, 'index'])->name('index');
    Route::get('/create', [Pelanggan::class, 'create'])->name('create');
    Route::post('/store', [Pelanggan::class, 'store'])->name('store');
    Route::get('/{kode_pelanggan}/edit', [Pelanggan::class, 'edit'])->name('edit');
    Route::put('/{kode_pelanggan}/update', [Pelanggan::class, 'update'])->name('update');
    Route::delete('/{kode_pelanggan}/destroy', [Pelanggan::class, 'destroy'])->name('destroy');
});

Route::prefix('barang')->name('barang.')->group(function () {
    Route::get('/', [Barang::class, 'index'])->name('index');
    Route::get('/create', [Barang::class, 'create'])->name('create');
    Route::post('/store', [Barang::class, 'store'])->name('store');
    Route::get('/{kode_barang}/edit', [Barang::class, 'edit'])->name('edit');
    Route::put('/{kode_barang}/update', [Barang::class, 'update'])->name('update');
    Route::delete('/{kode_barang}/destroy', [Barang::class, 'destroy'])->name('destroy');
});

Route::prefix('nota')->name('nota.')->group(function () {
    Route::get('/', [Nota::class, 'index'])->name('index');
    Route::get('/create', [Nota::class, 'create'])->name('create');
    Route::post('/store', [Nota::class, 'store'])->name('store');
    Route::get('/{no_nota}/show', [Nota::class, 'show'])->name('show');
});

Route::prefix('nota_barang')->name('nota_barang.')->group(function () {
    Route::get('/{id}/create', [NotaBarang::class, 'create'])->name('create');
    Route::post('/{id}/store', [NotaBarang::class, 'store'])->name('store');
    Route::get('/{id}/edit', [NotaBarang::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [NotaBarang::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [NotaBarang::class, 'destroy'])->name('destroy');
});