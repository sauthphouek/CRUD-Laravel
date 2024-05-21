<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login', [AuthenticationController::class, 'login']);

Route::group(["middleware" => "auth:api"], function () {

    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::prefix('notes')->group(function () {
        // GET api/notes
        Route::get('/', [NoteController::class, 'getNotes']);
        // POST create new note
        Route::post('/create', [NoteController::class, 'createNote']);
    });
});
