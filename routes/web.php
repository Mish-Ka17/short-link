<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RedirectController;

Route::get('/{code}', RedirectController::class)
    ->where('code', '[A-Za-z0-9]+');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/admin/login');
