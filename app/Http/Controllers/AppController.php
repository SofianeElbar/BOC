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
    return $this->appRepository->selectAll();
  }

  function showAuthorComments($id)
  {
    // return response()->json(Author::find($id));
    return $this->appRepository->selectById($id);
  }

  function createComment(Request $request, $id)
  {
    // $this->validate($request, [
    //   'title' => 'required',
    //   'content' => 'required'
    // ]);

    // $comment = Comment::create($request->all());

    // return response()->json($comment, 201);

    return $this->appRepository->createNew($request, $id);
  }

  function deleteComment($id)
  {
    return $this->appRepository->deleteCurrent($id);
  }

  function update($id, Request $request)
  {
    $author = Author::findOrFail($id);
    $author->update($request->all());

    return response()->json($author, 200);
  }

  function delete($id)
  {
    Author::findOrFail($id)->delete();
    return response('Deleted Successfully', 200);
  }
}
