<?php

use App\Http\Controllers\ChatController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RedisController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;





/*
|--------------------------------------------------------------------------
| backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {



        Route::get('/test', [SectionController::class, 'test']);




        //################ User dashboard ################//




        Route::group(['middleware' => ['auth:web', 'verified'], 'prefix' => 'dashboard/user'], function () {

            Route::get('/', function () {
                $products = Product::where('status', 1)->get();
                return view('Dashboard.User.dashboard', compact('products'));
            })->name('dashboard.user');


            Route::get('/product/{id}', [ProductController::class, 'show']);

            Route::get('/chat/{user_id}', [ChatController::class, 'chatForm']);
            Route::post('/chat/{user_id}', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

            Route::get('/payment/initiate/{id}', [PaymentController::class, 'payment'])->name('payment');
            Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
            Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

            Route::get('stripe/{price}', [StripePaymentController::class, 'stripe']);
            Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
        });










        //###############----------###################""//


        //################ Admin dashboard ################//



        Route::group(['middleware' => ['auth:admin', 'verified'], 'prefix' => 'dashboard/admin'], function () {


            Route::get('/', [MainController::class, 'index'])->name('dashboard.admin');
            Route::resource('/sections', SectionController::class);
            Route::get('/sectionproducts/{id}', [SectionController::class, 'getproducts']);
            Route::resource('/products', ProductController::class);
        });

        //###############----------###################""//


        require __DIR__ . '/auth.php';
    }
);


Route::get('/Redis', [RedisController::class, 'index']);
