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

$app->get('/', "AdminController@addApp");

$app->put('/',"AdminController@addAppHandel");

$app->get('/login', "LoginController@login");

$app->post('/login', "LoginController@loginHandel");

$app->get('list-apps',"AdminController@listOffers");

$app->patch('/offers/{id}/switch-visibility',"AdminController@switchOfferVisibility");

$app->delete('/offers/{id}/hide',"AdminController@hideOffer");

$app->group([
    'prefix' => '/api/v1/'
],function () use ($app) {
    $app->get('offers', 'APIController@getOffers');

    $app->get('offers/{offer}', 'APIController@getOffers');

    $app->post('user', 'APIController@getUserData');

    $app->post('user/credits','APIController@getUserCredits');

    $app->post('user/{user}', 'APIController@getUserData');

    $app->post('user/{user}/credits', 'APIController@getUserCredits');

});
