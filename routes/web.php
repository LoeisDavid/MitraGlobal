<?php

use App\Http\Controllers\Kategori;
use App\Http\Controllers\Merk;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merk;

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
    Route::get('/', [Kategori::class, 'index'])->name('index');
    Route::get('/create', [Kategori::class, 'create'])->name('create');
    Route::post('/store', [Kategori::class, 'store'])->name('store');
    Route::get('/{id}/edit', [Kategori::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [Kategori::class, 'update'])->name('update');
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
