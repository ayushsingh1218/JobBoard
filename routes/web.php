<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// routes/web.php

Route::get('/index', function () {
    return view('index');
});
