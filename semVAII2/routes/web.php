<?php

use App\Http\Controllers\CottageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
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
Route::get('/loginsuccess', function (){
  return view('loginsuccess');
});

Route::get('/', [CottageController::class, 'index'])->name('homepage');
Route::resource('cottage', CottageController::class);
Route::get('{cottage}/delete',[CottageController::class, 'destroy'])->name('cottage.delete');

Route::post('cottage/{cottage}',[CottageController::class, 'show'])->name('cottage.show');

Route::post('cottage/{id}/add',[ReservationController::class, 'reserve']);

Route::get('insertions', [UserController::class,'insertions'])->name('user.insertions');

Route::group(['middleware' => ['auth']],function(){
Route::get('user/action',[UserController::class,'action'])->name('user.action');
Route::resource('user', UserController::class);
Route::get('user/{user}/delete',[UserController::class, 'destroy'])->name('user.delete');
});



