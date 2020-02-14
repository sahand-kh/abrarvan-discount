<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function (){
    return "Welcome to discount micro system";
});



$router->get('discount', 'DiscountController@index');
$router->post('discount', 'DiscountController@store');
$router->get('discount/{discountCode}', 'DiscountController@show');
$router->delete('discount/{discountCode}', 'DiscountController@destroy');

$router->post('apply-discount', 'ApplyDiscountController@apply');
