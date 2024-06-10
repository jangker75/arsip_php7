<?php

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
CRUDBooster::routeController('admin/dashboard','AdminDashboardController');

Route::get('/', function () {
    return redirect('admin/login');
});

Route::get('/pdf/{id}','AdminBoxController@getPDF');
Route::get('/get-cabang-list/{clientId}', function($clientId){
    $data = DB::table('cabang')->where('client_id', $clientId)->get(['id', 'nama']);
    return response()->json($data);
})->name('get.cabang.list');
Route::get('/get-unitkerja-list/{clientId}/{cabangId}', function($clientId, $cabangId){
    $data = DB::table('unit_kerja')
    ->where('client_id', $clientId)
    ->where('cabang_id', $cabangId)->get(['id','nama']);
    return response()->json($data);
})->name('get.cabang.list');

Route::post('store/media', 'AdminCabangController@storeMedia')->name('admin.storeMedia');