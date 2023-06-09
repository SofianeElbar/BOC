<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(["prefix" => "api"], function () use ($router) {

    /*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

    $router->get("film/{id}/allvalidcomments", ["uses" => 'CommentController@getAllValidCommentsByFilm']);

    $router->get('subscriber/{id}/allcomments', ['uses' => 'SubscriberController@getAllCommentsBySubscriber']);

    $router->get('subscriber/{a}/film/{b}/alreadycommented', ['uses' => 'SubscriberController@alreadyCommented']);

    $router->get('subscriber/{id}/pseudo', ['uses' => 'SubscriberController@getPseudo']);

    $router->post('create', ['uses' => 'CommentController@createComment']);

    $router->put('subscriber/{id}/modifypseudo', ['uses' => 'SubscriberController@modifyPseudo']);

    /*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

    $router->get("allcomments", ["uses" => 'CommentController@getAllComments']);

    $router->put('moderate/{id}', ['uses' => 'ModerationController@moderateComment']);

    $router->put('validate/{id}', ['uses' => 'ModerationController@validateComment']);

    $router->put('reject/{id}', ['uses' => 'ModerationController@rejectComment']);
});
