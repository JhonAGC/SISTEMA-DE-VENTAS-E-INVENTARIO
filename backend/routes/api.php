<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('/cajas', 'CajaController');
Route::post('/articuloImages/articulo/{articulo}', 'ArticuloImageController@store');
Route::post('/articuloImages/articulo/delete/{articuloImage}', 'ArticuloImageController@destroy');
Route::get('/articuloImages/articulo/{articulo}', 'ArticuloImageController@show');
Route::get('/dashboard', 'DashboardController@info');
Route::get('/reportes/ventas/{venta}', 'VentaController@pdf');
Route::apiResource('/cajaMovimientos', 'CajaMovimientoController');



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
/* Route::resource('clientes', ClienteController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']); */
