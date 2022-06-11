<?php

use App\Http\Controllers\UserController;
use App\Jobs\SendAnniversary;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('job', function () {
    SendAnniversary::dispatch();
    return ['status' => true];
});

Route::get('import', [UserController::class, 'import']);
Route::get('import/admin', [UserController::class, 'importAdmin']);
