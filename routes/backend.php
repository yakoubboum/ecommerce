<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SectionController;
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


        
        Route::get('/test',[SectionController::class,'test']);




        //################ User dashboard ################//
        



        Route::group(['middleware' => ['auth:web', 'verified'], 'prefix' => 'dashboard/user'],function () {

            Route::get('/', function () {
                $products=Product::where('status',1)->get();
                return view('Dashboard.User.dashboard',compact('products'));
            })->name('dashboard.user');


            Route::get('/products', function () {
                return view('Dashboard.product-cart');
            });
            

            
        });










        //###############----------###################""//


        //################ Admin dashboard ################//

       

        Route::group(['middleware' => ['auth:admin', 'verified'], 'prefix' => 'dashboard/admin'],function () {

            Route::get('/', function () {
                return view('Dashboard.Admin.dashboard');
            })->name('dashboard.admin');

            Route::resource('/sections',SectionController::class);
            Route::get('/sectionproducts/{id}',[SectionController::class,'getproducts']);
            Route::resource('/products',ProductController::class);
            
            
        });

        //###############----------###################""//


        require __DIR__ . '/auth.php';
    }
);
