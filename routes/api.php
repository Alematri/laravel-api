<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PageController;

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

// Route::get('/prova-api', function(){
//     $user = [
//         'name' => 'Ugo',
//         'lastname' => 'De Ughi'
//     ];
//     $success = true;

//     // non restituisco un view ma un file json
//     return response()->json(compact('user','success'));
// });

Route::get('/projects', [PageController::class, 'index']);
Route::get('/projects/get-project/{slug}', [PageController::class, 'getprojectBySlug']);





Route::get('/prova-api', [PageController::class, 'prova']);
