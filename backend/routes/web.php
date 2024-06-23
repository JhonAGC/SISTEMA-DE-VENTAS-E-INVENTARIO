<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', 'UserController@login');
    Route::apiResource('/users', 'UserController');

    Route::apiResource('/marcas', 'MarcaController');
    Route::apiResource('/medidas', 'MedidaController');
    Route::apiResource('/categorias', 'CategoriaController');

    Route::apiResource('/clientes', 'ClienteController');
    Route::apiResource('/proveedors', 'ProveedorController');
    Route::apiResource('/metodos', 'MetodoController');
    Route::apiResource('/boletas', 'BoletaController');
    Route::apiResource('/facturas', 'FacturaController');

    Route::apiResource('/articulos', 'ArticuloController');
    Route::get('/inventarios/kardex/{articulo}', 'InventarioController@kardex');
    Route::apiResource('/inventarios', 'InventarioController');
    Route::apiResource('/compras', 'CompraController');
    Route::apiResource('/ventas', 'VentaController');
    Route::apiResource('/sucursals', 'SucursalController');
});


Route::get('/', function () {
    return view('welcome');
});
