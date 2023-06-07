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
| Comment Routes
|--------------------------------------------------------------------------
*/

    $router->get("allcomments", ["uses" => 'CommentController@getAllComments']);

    $router->get("allvalidcomments", ["uses" => 'CommentController@getAllValidComments']);

    $router->post("film/allcomments", ["uses" => 'CommentController@getAllCommentsByFilm']);

    $router->post("film/allvalidcomments", ["uses" => 'CommentController@getAllValidCommentsByFilm']);

    // $router->get("film/{id}/authors", ["uses" => 'AppController@showAuthorsByFilm']);

    /*
|--------------------------------------------------------------------------
| Subscriber Routes
|--------------------------------------------------------------------------
*/

    $router->post('subscriber/allcomments', ['uses' => 'SubscriberController@getAllCommentsBySubscriber']);

    $router->post('subscriber/pseudo', ['uses' => 'SubscriberController@getPseudo']);

    $router->put('subscriber/modifypseudo', ['uses' => 'SubscriberController@modifyPseudo']);

    $router->post('subscriber/alreadycommented', ['uses' => 'SubscriberController@alreadyCommented']);

    $router->post('create', ['uses' => 'SubscriberController@createComment']);



    $router->delete('delete/{id}', ['uses' => 'AppController@deleteComment']);

    $router->put('comments/{id}', ['uses' => 'AppController@updateComment']);

    // Moderation routes
    $router->put('changestatus/{id}', ['uses' => 'AppController@changeCommentStatus']);

    $router->put('modify/{id}', ['uses' => 'AppController@modifyComment']);

    $router->put('moderate/{id}', ['uses' => 'AppController@moderateComment']);

    $router->put('validate/{id}', ['uses' => 'AppController@validateComment']);

    $router->put('reject/{id}', ['uses' => 'AppController@rejectComment']);
});
