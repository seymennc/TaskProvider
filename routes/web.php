<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;

Route::get('calculate', function (){
   $calculator = new \App\Helpers\CalculatorHelper();
    $calculator->calculate();
});
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.*');
