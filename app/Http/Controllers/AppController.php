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

  function showCommentsByAuthor($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectAuthorById($id);
  }

  function showCommentsByFilm($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectFilmById($id);
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
