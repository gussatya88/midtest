<?php

use App\Http\Controllers\CategoryResourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductResourceController;
use App\Http\Controllers\PackageResourceController;
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

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/{id}/product', [DashboardController::class, 'showProduct'])->name('show.product');

Route::resource('category', CategoryResourceController::class, ['except' => ['show', 'create']]);
Route::resource('product', ProductResourceController::class);
Route::resource('package', PackageResourceController::class);
Route::get('/product/{package}/add-to-package', [PackageResourceController::class, 'viewAddProductToPackage'])->name('package.viewAddProduct');
Route::post('/product/{package}/add-to-package', [PackageResourceController::class, 'addProductToPackage'])->name('package.addProduct');
Route::delete('/product/{package}/delete-from-package', [PackageResourceController::class, 'deleteProductFromPackage'])->name('package.deleteProduct');