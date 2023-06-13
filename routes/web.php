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

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', 'ConsultorController@index')->name('index');

Route::get('desempenho', 'ConsultorController@desempenho')->name('desempenho');

Route::post('desempenho-graph-linebar', 'ConsultorController@graficaLineBar')->name('graph_linebar');

Route::post('desempenho-graph-pizza', 'ConsultorController@graficaPizza')->name('graph_pizza');