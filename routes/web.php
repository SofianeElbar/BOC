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

    $router->get("comments", ["uses" => 'AppController@showAllComments']);

    $router->get("validcomments", ["uses" => 'AppController@showAllValidatedComments']);

    $router->get("film/{id}", ["uses" => 'AppController@showCommentsByFilm']);

    $router->get("film/{id}/validcomments", ["uses" => 'AppController@showAllValidatedCommentsByFilm']);

    $router->get('author/{id}', ['uses' => 'AppController@showCommentsByAuthor']);

    $router->post('create', ['uses' => 'AppController@createComment']);

    $router->delete('comments/{id}', ['uses' => 'AppController@deleteComment']);

    $router->put('comments/{id}', ['uses' => 'AppController@updateComment']);
});
