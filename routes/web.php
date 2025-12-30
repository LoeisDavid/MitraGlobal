<?php

use App\Http\Controllers\Kategori;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [Kategori::class, 'index'])->name('index');
    Route::get('/create', [Kategori::class, 'create'])->name('create');
    Route::post('/store', [Kategori::class, 'store'])->name('store');
    Route::get('/{id}/edit', [Kategori::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [Kategori::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [Kategori::class, 'destroy'])->name('destroy');
});
