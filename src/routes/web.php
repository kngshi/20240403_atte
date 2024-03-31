<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\RestController;
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



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [UserController::class, 'index']);

Route::post('/', [TimeController::class, 'store']);
// この下に、RestControllerでupdateアクションを作れば良い？
// Route::post('/', [RestController::class, 'update']);

Route::post('/time/start', [TimeController::class, 'start'])->name('time.start');
Route::post('/time/end', [TimeController::class, 'end'])->name('time.end');

Route::post('/rest/start', [RestController::class, 'start'])->name('rest.start');
Route::post('/rest/end', [RestController::class, 'end'])->name('rest.end');


Route::get('/attendance', [TimeController::class, 'attendance']);
