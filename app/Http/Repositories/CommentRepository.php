<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class CommentRepository
{

  function getAllComments()
  {
    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk = comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber = comments.id_subscriber_fk";

    $bindings = [];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function getAllValidComments()
  {
    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = :valide";

    $bindings = ['valide' => 'Valide'];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function getAllCommentsByFilm($id)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE id_film = :id";

    $bindings = ['id' => $id];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function getAllValidCommentsByFilm($id)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = :valide AND id_film = :id";

    $bindings = ['id' => $id, 'valide' => 'Valide'];

    $array = DB::select($query, $bindings);

    return $array;
  }
}
