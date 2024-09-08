<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/foo', function () {
    echo('Foo');
    $parser = new \App\Services\Parsers\DuskParser();
    $parser->parse();
});
