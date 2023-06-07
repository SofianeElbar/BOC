<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Http\Repositories\CommentRepository;
use App\Providers\AppServiceProvider;

class CommentController extends BaseController
{

  protected CommentRepository $commentRepository;

  public function __construct(CommentRepository $commentRepository)
  {
    $this->commentRepository = $commentRepository;
  }

  function getAllComments()
  {
    $result = $this->commentRepository->getAllComments();

    if (count($result) === 0) {
      return response()->json(['No comments found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function getAllValidComments()
  {
    $result = $this->commentRepository->getAllValidComments();

    if (count($result) === 0) {
      return response()->json(['No comments found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function getAllCommentsByFilm(Request $request)
  {
    $id = $request->input('id');
    $result = $this->commentRepository->getAllCommentsByFilm($id);

    if (count($result) === 0) {
      return response()->json(['No comments found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function getAllValidCommentsByFilm(Request $request)
  {
    $id = $request->input('id');
    $result = $this->commentRepository->getAllValidCommentsByFilm($id);

    if (count($result) === 0) {
      return response()->json(['No comments found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }
}
