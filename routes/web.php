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

$app->get('list-apps',"AdminController@listOffers");

$app->patch('/offers/{id}/switch-visibility',"AdminController@switchOfferVisibility");

$app->delete('/offers/{id}/hide',"AdminController@hideOffer");

$app->get('/api/v1/offers', 'APIController@getOffers');

$app->get('/api/v1/user', 'APIController@getUserData');

