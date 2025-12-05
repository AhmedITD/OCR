<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/demo');
});

Route::get('/demo', [DemoController::class, 'index'])->name('demo');

Route::get('/docs', function () {
    return view('docs');
})->name('docs');
