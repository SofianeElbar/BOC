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

    $router->get("film/{id}/authors", ["uses" => 'AppController@showAuthorsByFilm']);

    $router->get("film/{id}/validcomments", ["uses" => 'AppController@showAllValidatedCommentsByFilm']);

    $router->get('author/{id}', ['uses' => 'AppController@showCommentsByAuthor']);

    $router->get('author/{id}/pseudo', ['uses' => 'AppController@showPseudoByAuthor']);

    $router->post('create', ['uses' => 'AppController@createComment']);

    $router->delete('comments/{id}', ['uses' => 'AppController@deleteComment']);

    $router->put('comments/{id}', ['uses' => 'AppController@updateComment']);

    $router->put('validate/{id}', ['uses' => 'AppController@validateComment']);

    $router->put('reject/{id}', ['uses' => 'AppController@rejectComment']);
});
