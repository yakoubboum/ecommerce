<?php

use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SectionController;
use Illuminate\Support\Facades\Route;
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
        Route::get('/dashboard/user', function () {
            return view('Dashboard.User.dashboard');
        })->middleware(['auth:web', 'verified'])->name('dashboard.user');



        //###############----------###################""//


        //################ Admin dashboard ################//

       

        Route::group(['middleware' => ['auth:admin', 'verified'], 'prefix' => 'dashboard/admin'],function () {

            Route::get('/', function () {
                return view('Dashboard.Admin.dashboard');
            })->name('dashboard.admin');

            Route::resource('/sections',SectionController::class);
            Route::resource('/products',ProductController::class);
            
            
        });

        //###############----------###################""//


        require __DIR__ . '/auth.php';
    }
);
