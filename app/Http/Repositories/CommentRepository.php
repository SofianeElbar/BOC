<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class CommentRepository
{

  // function getAllComments()
  // {
  //   $query = "SELECT * FROM comments 
  //             JOIN moderations ON moderations.id_comment_fk = comments.id_comment 
  //             JOIN subscribers ON subscribers.id_subscriber = comments.id_subscriber_fk";

  //   $bindings = [];

  //   $array = DB::select($query, $bindings);

  //   return $array;
  // }

  // function getAllValidComments()
  // {
  //   $query = "SELECT * FROM comments 
  //             JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
  //             JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = :valide";

  //   $bindings = ['valide' => 'Valide'];

  //   $array = DB::select($query, $bindings);

  //   return $array;
  // }

  // function getAllCommentsByFilm($id)
  // {

  //   $query = "SELECT * FROM comments 
  //             JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
  //             JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE id_film = :id";

  //   $bindings = ['id' => $id];

  //   $array = DB::select($query, $bindings);

  //   return $array;
  // }

  function sanitizeInput($input)
  {
    $sanitizedInput = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $sanitizedInput;
  }

  function getAllValidCommentsByFilm($id_film)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = :valide AND id_film = :id";

    $bindings = ['id' => $id_film, 'valide' => 'Valide'];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function createComment($content, $id_film, $film_title, $id_subscriber)
  {

    $cleanContent = $this->sanitizeInput($content);

    // Create comment row in comment table
    $query = "INSERT INTO comments (id_subscriber_fk, id_film, film_title, content) VALUES (:id_subscriber_fk, :id_film, :film_title, :content)";

    $bindings = ['id_subscriber_fk' => $id_subscriber, 'id_film' => $id_film, 'film_title' => $film_title, 'content' => $cleanContent];

    DB::insert($query, $bindings);

    $id_comment = DB::getPdo()->lastInsertId();

    // Create moderation row in moderation table
    $query = "INSERT INTO moderations (id_comment_fk, id_moderator_fk, status) VALUES (:id_comment_fk, :id_moderator_fk, :status)";

    $bindings = ['id_comment_fk' => $id_comment, 'id_moderator_fk' => 27, 'status' => 'Valide'];

    $inserted = DB::insert($query, $bindings);

    return (bool) $inserted;
  }
}
