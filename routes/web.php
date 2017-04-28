<?php

$app->get('/', "AdminController@addApp");

$app->put('/',"AdminController@addAppHandel");

$app->get('/login', "LoginController@login");

$app->post('/login', "LoginController@loginHandel");

$app->get('/logout', "LoginController@logout");

$app->get('/registration', "RegistrationController@registration");

$app->post('/registration', "RegistrationController@registrationHandel");

$app->get('list-apps',"AdminController@listOffers");

$app->get('list-users', "AdminController@listUsers");

$app->get('list-installs', "AdminController@listOfferInstalls");

$app->get('/list-recharge', 'AdminController@listRecharge');

$app->patch('/request/recharge/{id}/approve', 'AdminController@approveRecharge');

$app->delete('/users/{id}/delete', "AdminController@deleteUser");

$app->patch('/offers/{id}/switch-visibility',"AdminController@switchOfferVisibility");

$app->delete('/offers/{id}/delete',"AdminController@deleteOffer");

$app->get('/api/list',"AdminController@listAPI");

$app->get('/referral/{code}', function ($code) {
    $url = "https://play.google.com/store/apps/details?id=com.mobcash.app&referrer=utm_source%3Dreferral%26utm_content%3D" . $code;
    return redirect()->to($url);
});

$app->post('/password/reset/request', "LoginController@passwordRestRequest");

$app->get('/password/reset/{id}/{token}', ['as' => 'reset.email', 'uses' => "LoginController@passwordRest"]);

$app->group([
    'prefix' => '/api/v1/'
],function () use ($app) {
    $app->post('offers', 'APIController@getOffers');

    $app->post('offers/{offer}', 'APIController@getOffers');

    $app->post('user', 'APIController@getUserData');

    $app->post('user/create', 'APIController@createUser');

    $app->post('user/login', 'APIController@loginUser');

    $app->patch('user/verified', 'APIController@toggleVerification');

    $app->patch('user/password', 'APIController@changePassword');

    $app->post('user/credits','APIController@getUserCredits');

    $app->post('user/credit/logs', 'APIController@creditLogs');

//    $app->post('user/{user}', 'APIController@getUserData');

//    $app->post('user/{user}/credits', 'APIController@getUserCredits');

    $app->post('/app/installed', 'APIController@offerInstallLogs');

    $app->post('/app/install/success', 'APIController@offerInstall');

    $app->post('/request/recharge', 'APIController@requestRecharge');

});