<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('legacy.index');
})->name('login');

Route::get('/login', function () {
    return view('legacy.index');
});

Route::post('/login', [AuthController::class, 'login'])->name('login.store');

$pages = [
    'dashboard',
    'forgot-password',
    'pos',
    'products',
    'categories',
    'brands',
    'units',
    'customers',
    'suppliers',
    'purchases',
    'purchase-report',
    'sales',
    'add-sale',
    'sale-return',
    'sales-report',
    'payments',
    'expenses',
    'expense-categories',
    'expense-report',
    'stock',
    'stock-report',
    'profit-loss',
    'tax-report',
];

foreach ($pages as $page) {
    Route::view("/{$page}", "legacy.{$page}")->name($page);
    Route::view("/{$page}.html", "legacy.{$page}");
}
