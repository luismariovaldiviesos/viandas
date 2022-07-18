<?php

use App\Http\Livewire\Categories;
use App\Http\Livewire\Customers;
use App\Http\Livewire\Products;
use App\Http\Livewire\Reports;
use App\Http\Livewire\Sales;
use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('categories', Categories::class)->name('categories');
Route::get('products', Products::class)->name('products');
Route::get('customers', Customers::class)->name('customers');
Route::get('users', Users::class)->name('users');
Route::get('sales', Sales::class)->name('sales');
Route::get('reports', Reports::class)->name('reports');


// ruta principal
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
