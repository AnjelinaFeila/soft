<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockRawController;
use App\Http\Controllers\WipController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\TonaseController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\ExhandlerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;

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


Route::group(['middleware' => 'auth'], function () {

	Route::get('/export-laporan', [ExportController::class, 'exportToExcel1'])->name('export-laporan');
	Route::get('/export-stockraw', [ExportController::class, 'exportToExcel2'])->name('export-stockraw');
	Route::get('/handlaporan', [ExhandlerController::class, 'Handler1'])->name('handlaporan');

    Route::get('/', [HomeController::class, 'home'])->name('dashboard');

    Route::get('/dashboard', [HomeController::class, 'dash'])->name('dashboard');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');


	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');
	
	Route::get('add_user', function () {
		return view('laravel-examples/add_user');
	})->name('add_user');

	Route::get('stockraw', function () {
		return view('stockraw');
	})->name('stockraw');

	Route::get('stockraw_add', function () {
		return view('stockraw_add');
	})->name('stockraw_add');

	Route::get('customer', function () {
		return view('customer');
	})->name('customer');

	Route::get('customer_add', function () {
		return view('customer_add');
	})->name('customer_add');

	Route::get('tonase', function () {
		return view('tonase');
	})->name('tonase');

	Route::get('tonase_add', function () {
		return view('tonase_add');
	})->name('tonase_add');

	Route::get('operator', function () {
		return view('operator');
	})->name('operator');

	Route::get('operator_add', function () {
		return view('operator_add');
	})->name('operator_add');

	Route::get('proses', function () {
		return view('proses');
	})->name('proses');

	Route::get('proses_add', function () {
		return view('proses_add');
	})->name('proses_add');

	Route::get('supplier', function () {
		return view('supplier');
	})->name('supplier');

	Route::get('supplier_add', function () {
		return view('supplier_add');
	})->name('supplier_add');

	Route::get('wip', function () {
		return view('wip');
	})->name('wip');

	Route::get('wip_add', function () {
		return view('wip_add');
	})->name('wip_add');

	Route::get('material', function () {
		return view('material');
	})->name('material');

	Route::get('material_add', function () {
		return view('material_add');
	})->name('material_add');

	Route::get('delivery', function () {
		return view('delivery');
	})->name('delivery');

	Route::get('delivery_add', function () {
		return view('delivery_add');
	})->name('delivery_add');

	Route::get('laporan', function () {
		return view('laporan');
	})->name('laporan');

	Route::get('laporan_add', function () {
		return view('laporan_add');
	})->name('laporan_add');


  	Route::get('/user-management', [UserManageController::class, 'index']);
    Route::post('/user-management', [UserManageController::class, 'store']);
    Route::get('/showuser/{id}', [UserManageController::class, 'show'])->name('user.showuser');
    Route::post('/user-management/{id}', [UserManageController::class, 'update'])->name('user.update');
    Route::delete('/user-management/{id}', [UserManageController::class, 'destroy'])->name('user.destroy');

	Route::get('/tonase', [TonaseController::class, 'index']);
    Route::post('/tonase', [TonaseController::class, 'store']);
    Route::get('/showtonase/{id}', [TonaseController::class, 'show'])->name('tonase.showtonase');
    Route::post('/tonase/{id}', [TonaseController::class, 'update'])->name('tonase.update');
    Route::delete('/tonase/{id}', [TonaseController::class, 'destroy'])->name('tonase.destroy');

    Route::get('/operator', [OperatorController::class, 'index']);
    Route::post('/operator', [OperatorController::class, 'store']);
    Route::get('/showoperator/{id}', [OperatorController::class, 'show'])->name('operator.showoperator');
    Route::post('/operator/{id}', [OperatorController::class, 'update'])->name('operator.update');
    Route::delete('/operator/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');

    Route::get('/proses', [ProsesController::class, 'index']);
    Route::post('/proses', [ProsesController::class, 'store']);
    Route::get('/showproses/{id}', [ProsesController::class, 'show'])->name('proses.showproses');
    Route::post('/proses/{id}', [ProsesController::class, 'update'])->name('proses.update');
    Route::delete('/proses/{id}', [ProsesController::class, 'destroy'])->name('proses.destroy');

	Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer', [CustomerController::class, 'store']);
    Route::get('/showcustomer/{id}', [CustomerController::class, 'show'])->name('customer.showcustomer');
    Route::post('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::post('/supplier', [SupplierController::class, 'store']);
    Route::get('/showsupplier/{id}', [SupplierController::class, 'show'])->name('supplier.showsupplier');
    Route::post('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

	Route::get('/wip', [WipController::class, 'index']);
    Route::get('/wip_add', [WipController::class, 'index2']);
    Route::post('/wip', [WipController::class, 'store']);
    Route::get('/showwip/{id}', [WipController::class, 'show'])->name('wip.showwip');
    Route::post('/wip/{id}', [WipController::class, 'update'])->name('wip.update');
    Route::delete('/wip/{id}', [WipController::class, 'destroy'])->name('wip.destroy');

    Route::get('/stockraw', [StockRawController::class, 'index']);
    Route::get('/stockraw_add', [StockRawController::class, 'index2']);
    Route::post('/stockraw', [StockrawController::class, 'store']);
    Route::get('/showstock/{id}', [StockrawController::class, 'show'])->name('stock.showstock');
    Route::post('/stockraw/{id}', [StockrawController::class, 'update'])->name('stock.update');
    Route::delete('/stockraw/{id}', [StockrawController::class, 'destroy'])->name('stock.destroy');

    Route::get('/delivery', [DeliveryController::class, 'index']);
    Route::get('/delivery_add', [DeliveryController::class, 'index2']);
    Route::post('/delivery', [DeliveryController::class, 'store']);
    Route::get('/showdelivery/{id}', [DeliveryController::class, 'show'])->name('delivery.showdelivery');
    Route::post('/delivery/{id}', [DeliveryController::class, 'update'])->name('delivery.update');
    Route::delete('/delivery/{id}', [DeliveryController::class, 'destroy'])->name('delivery.destroy');

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan_add', [LaporanController::class, 'index2']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/showlaporan/{id}', [LaporanController::class, 'show'])->name('laporan.showlaporan');
    Route::post('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/material', [MaterialController::class, 'index']);
    Route::get('/material_add', [MaterialController::class, 'index2']);
    Route::post('/material', [MaterialController::class, 'store']);
    Route::get('/material/{id}', [MaterialController::class, 'show'])->name('materials.showmat');
    Route::post('/material/{id}', [MaterialController::class, 'update'])->name('materials.update');
    Route::delete('/material/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');


});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');