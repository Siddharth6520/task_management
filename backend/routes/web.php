<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {

    return view('welcome');
});

Route::get('/dashboard', function(){
    return view('dashboard');
});

Route::get('/mongo-test', function () {

    DB::connection('mongodb')->getMongoClient();

    return 'MongoDB Connected';
});