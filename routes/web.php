<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderServiceController;
use App\Http\Controllers\Admin\PitchController;
use App\Http\Controllers\Admin\PitchTypeController;
use App\Http\Controllers\Admin\RegulationController;
use App\Http\Controllers\Admin\RetailController;
use App\Http\Controllers\Admin\RetailDetailController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

/*
 * Admin
 */
 Route::prefix('admin')->name('admin.')->middleware('auth', 'user_actived')->group(function () {
     Route::get('/', [AdminController::class, 'index'])->name('index');

     Route::resource('/roles', RoleController::class);
     Route::resource('/users', UserController::class);

     Route::resource('/pitch-types', PitchTypeController::class);
     Route::resource('/regulations', RegulationController::class);
     Route::resource('/service-types', ServiceTypeController::class);
     Route::resource('/services', ServiceController::class);
     Route::resource('/customers', CustomerController::class);
     Route::resource('/pitches', PitchController::class);
     Route::get('/pitches/get/all', [PitchController::class, 'getAll'])->name('pitches.getAll');Route::get('/pitches/get/all', [PitchController::class, 'getAll'])->name('pitches.getAll');

     // Customer
     Route::get('/customers/get/{phoneNumber}', [CustomerController::class, 'get'])->name('customers.get');

     // Order
     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
     Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
     Route::get('/orders/create/{date}', [OrderController::class, 'create'])->name('orders.create');
     Route::get('/orders/edit/{order}/{date}', [OrderController::class, 'edit'])->name('orders.edit');
     Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
     Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
     Route::post('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
     Route::post('orders/{order}/take', [OrderController::class, 'take'])->name('orders.take');
     Route::get('/orders/get/{date}', [OrderController::class, 'getByDate'])->name('orders.getByDate');

     // Pitch booking status
     Route::get('/pitch-booking-status', [OrderController::class, 'pitchBookingStatus'])->name('pitch-booking-status.index');

    // Order Service
    Route::get('orders/order-services/{order}', [OrderServiceController::class, 'index'])
        ->name('order-services.index');
    Route::get('orders/order-services/{order}/create', [OrderServiceController::class, 'create'])
        ->name('order-services.create');
    Route::post('orders/order-services/{order}', [OrderServiceController::class, 'store'])
        ->name('order-services.store');
    Route::get('orders/order-services/{order}/{orderService}/edit', [OrderServiceController::class, 'edit'])
        ->name('order-services.edit');
    Route::patch('orders/order-services/{orderService}/{date}', [OrderServiceController::class, 'update'])
        ->name('order-services.update');
    Route::delete('orders/order-services/{orderService}', [OrderServiceController::class, 'destroy'])
        ->name('order-services.destroy');

    // Retail
    Route::get('retails', [RetailController::class, 'index'])->name('retails.index');
    Route::get('retails/create', [RetailController::class, 'create'])->name('retails.create');
    Route::delete('retails/{retail}', [RetailController::class, 'destroy'])->name('retails.destroy');
    Route::patch('retails/{retail}/pay', [RetailController::class, 'pay'])->name('retails.pay');
    // Retail Detail
    Route::get('retails/{retail}/retail-details/', [RetailDetailController::class, 'index'])->name('retail-details.index');
    Route::get('retails/{retail}/retail-details/create', [RetailDetailController::class, 'create'])->name('retail-details.create');
    Route::post('retails/{retail}/retail-details', [RetailDetailController::class, 'store'])->name('retail-details.store');
    Route::get('retails/{retail}/retail-details/{retailDetail}', [RetailDetailController::class, 'edit'])->name('retail-details.edit');
    Route::patch('retails/retail-details/{retailDetail}', [RetailDetailController::class, 'update'])->name('retail-details.update');
    Route::delete('retails/retail-details/{retailDetail}', [RetailDetailController::class, 'destroy'])->name('retail-details.destroy');

    // Sales
    Route::get('sales/{date1?}/{date2?}/{option?}', [SaleController::class, 'index'])->name('sales.index');

    // Setting
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
 });

 /*
  * Home Page
  */
  Route::get('api/pitches/get', [HomeController::class, 'getPitches'])->name('api.getPitches');
  Route::get('/', [HomeController::class, 'index'])->name('pages.index');
  Route::get('api/orders/get/{date?}', [HomeController::class, 'getOrders'])->name('api.getOrders');

 /*
  * Authenticate
  */
Route::get('logout', function () {
    Auth::logout();
    return redirect()->route('login');
});


