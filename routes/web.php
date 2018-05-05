<?php

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

Route::get('/get_road_works', 'RoadacCidentsController@getRoadWorks');
Route::get('/get_road_accidents', 'RoadacCidentsController@getRoadAccidents');
Route::get('/get_road_emergencies', 'RoadacCidentsController@getRoadEmergencies');
Route::post('/uploads', 'FilesController@uploads');
