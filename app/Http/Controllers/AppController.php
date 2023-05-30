<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Comment;
use App\Http\Repositories\AppRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AppController extends BaseController
{

  protected AppRepository $appRepository;

  public function __construct(AppRepository $appRepository)
  {
    $this->appRepository = $appRepository;
  }

  function showAllComments()
  {
    // return response()->json(Comment::all());
    return $this->appRepository->selectAllJoined();
  }

  function showAllValidatedComments()
  {
    // return response()->json(Comment::all());
    return $this->appRepository->selectAllValidated();
  }

  function showAllValidatedCommentsByFilm($id)
  {
    // return response()->json(Comment::all());
    return $this->appRepository->selectAllValidatedByFilm($id);
  }

  function showAllValidatedCommentsByAuthor($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectAllValidatedByAuthor($id);
  }

  function showAllValidatedCommentsByAuthorbyFilm($idKinow, $idFilm)
  {
    return $this->appRepository->selectAllValidatedByAuthorByFilm($idKinow, $idFilm);
  }

  function showAuthorsByFilm($id)
  {
    // return response()->json(Comment::all());
    return $this->appRepository->selectAuthorsByFilm($id);
  }

  function showCommentsByFilm($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectFilmById($id);
  }

  function showPseudoByAuthor($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectPseudoByAuthor($id);
  }

  function modifyPseudoByAuthor($id, $pseudo)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->updatePseudoByAuthor($id, $pseudo);
  }

  function createComment(Request $request)
  {
    // $this->validate($request, [
    //   'title' => 'required',
    //   'content' => 'required'
    // ]);

    // $comment = Comment::create($request->all());

    // return response()->json($comment, 201);

    return $this->appRepository->createNew($request);
  }

  function deleteComment($id)
  {
    return $this->appRepository->deleteCurrent($id);
  }

  function moderateComment($id, Request $request)
  {
    return $this->appRepository->moderateCurrent($id);
  }

  function validateComment($id, Request $request)
  {
    return $this->appRepository->validateCurrent($id);
  }

  function rejectComment($id, Request $request)
  {
    return $this->appRepository->rejectCurrent($id);
  }

  function changeCommentStatus($id, Request $request)
  {
    return $this->appRepository->changeCurrent($id);
  }

  function update($id, Request $request)
  {
    // $author = Author::findOrFail($id);
    // $author->update($request->all());

    // return response()->json($author, 200);
  }

  // function delete($id)
  // {
  //   Author::findOrFail($id)->delete();
  //   return response('Deleted Successfully', 200);
  // }
}
