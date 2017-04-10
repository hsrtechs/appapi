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

$app->get('/logout', "LoginController@logout");

$app->get('/registration', "RegistrationController@registration");

$app->post('/registration', "RegistrationController@registrationHandel");

$app->get('list-apps',"AdminController@listOffers");

$app->get('list-users', "AdminController@listUsers");

$app->delete('/users/{id}/delete', "AdminController@deleteUser");

$app->patch('/offers/{id}/switch-visibility',"AdminController@switchOfferVisibility");

$app->delete('/offers/{id}/delete',"AdminController@deleteOffer");

$app->get('/api/list',"AdminController@listAPI");

$app->group([
    'prefix' => '/api/v1/'
],function () use ($app) {
    $app->post('offers', 'APIController@getOffers');

    $app->post('offers/{offer}', 'APIController@getOffers');

    $app->post('user', 'APIController@getUserData');

    $app->post('user/credits','APIController@getUserCredits');

    $app->post('user/{user}', 'APIController@getUserData');

    $app->post('user/{user}/credits', 'APIController@getUserCredits');

    $app->post('installs/success', 'APIController@offerInstallLogs');


});
