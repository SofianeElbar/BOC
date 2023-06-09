<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\SubscriberRepository;
use App\Providers\AppServiceProvider;

class CommentController extends BaseController
{

  protected CommentRepository $commentRepository;
  protected SubscriberRepository $subscriberRepository;

  public function __construct(CommentRepository $commentRepository, SubscriberRepository $subscriberRepository)
  {
    $this->commentRepository = $commentRepository;
    $this->subscriberRepository = $subscriberRepository;
  }

  // function getAllComments()
  // {
  //   $result = $this->commentRepository->getAllComments();

  //   if (count($result) === 0) {
  //     return response()->json(['No comments found.'], 404);
  //   } else {
  //     return AppServiceProvider::translateIntoArrayofObjects($result);
  //   }
  // }

  // function getAllValidComments()
  // {
  //   $result = $this->commentRepository->getAllValidComments();

  //   if (count($result) === 0) {
  //     return response()->json(['No comments found.'], 404);
  //   } else {
  //     return AppServiceProvider::translateIntoArrayofObjects($result);
  //   }
  // }

  // function getAllCommentsByFilm($id)
  // {
  //   if (!$id) {
  //     return response()->json(['No argument passed.'], 404);
  //   } else {
  //     $result = $this->commentRepository->getAllCommentsByFilm($id);
  //   }

  //   if (!$result) {
  //     return response()->json(['No comments found.'], 404);
  //   } else {
  //     return AppServiceProvider::translateIntoArrayofObjects($result);
  //   }
  // }

  function getAllValidCommentsByFilm($id)
  {
    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->commentRepository->getAllValidCommentsByFilm($id);
    }

    if (!$result) {
      return response()->json(['error' => 'No comments found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function createComment(Request $request)
  {

    $content = $request->input('content');
    $email = $request->input('email');
    $pseudo = $request->input('pseudo');
    $id_kinow = $request->input('idKinow');
    $id_film = $request->input('idFilm');
    $film_title = $request->input('filmTitle');

    // Check if there are empty fields
    $field_to_check = ['content', 'email', 'pseudo', 'idKinow', 'idFilm', 'filmTitle'];
    $emptyFields = [];

    foreach ($field_to_check as $field) {
      if (!$request->input($field)) {
        $emptyFields[] = $field;
      }
    }

    if ($emptyFields) {
      return response()->json(['Oops, empty fields: ' . implode(", ", $emptyFields)], 404);
    }

    // Check if subscriber already exists in database
    $id_subscriber = $this->subscriberRepository->getSubscriberDatabaseId($id_kinow);

    // Check if subscriber has already commented
    $has_commented = $this->subscriberRepository->alreadyCommented($id_kinow, $id_film);

    if ($id_subscriber === null && !$has_commented) {

      $this->subscriberRepository->createSubscriberInDatabase($id_kinow, $email, $pseudo);

      $id_subscriber = $this->subscriberRepository->getSubscriberDatabaseId($id_kinow);

      $result = $this->commentRepository->createComment($content, $id_film, $film_title, $id_subscriber);
    } else if ($id_subscriber !== null && !$has_commented) {

      $id_subscriber = $this->subscriberRepository->getSubscriberDatabaseId($id_kinow);

      $result = $this->commentRepository->createComment($content, $id_film, $film_title, $id_subscriber);
    }

    if (!isset($result) || !$result) {
      return response()->json(['error' => 'Subscriber already commented.'], 404);
    } else {
      return response()->json(['success' => 'Added successfully.'], 200);
    }
  }
}
