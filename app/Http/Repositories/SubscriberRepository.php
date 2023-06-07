<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class SubscriberRepository
{

  function getAllCommentsBySubscriber($id)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE id_kinow = :id";

    $bindings = ['id' => $id];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function getPseudo($id_kinow, $email)
  {

    $query = "SELECT pseudo, :email AS email FROM subscribers WHERE id_kinow = :id_kinow";

    $bindings = ['id_kinow' => $id_kinow, 'email' => $email];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function modifyPseudo($id, $pseudo)
  {

    $query = "UPDATE subscribers SET pseudo = :pseudo WHERE id_kinow = :id";

    $bindings = ['id' => $id, 'pseudo' => $pseudo];

    $array = DB::select($query, $bindings);

    return true;
  }

  function alreadyCommented($id_kinow, $id_film)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk
              WHERE status = :valide
              AND id_kinow = :id_kinow 
              AND id_film = :id_film";

    $bindings = ['valide' => 'Valide', 'id_kinow' => $id_kinow, 'id_film' => $id_film];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function createComment($cleanContent, $email, $cleanPseudo, $id_kinow, $id_film, $film_title, $exists)
  {

    if ($exists) {
      // Don't create a subscriber row
      $query = "SELECT id_subscriber FROM subscribers WHERE id_kinow = :id_kinow";

      $bindings = ['id_kinow' => $id_kinow];

      $id_subscriber = DB::selectOne($query, $bindings)->id_subscriber;
    } else {

      // Create subscriber row in subscriber table
      $query = "INSERT INTO subscribers (id_kinow, email, pseudo) VALUES (:id_kinow, :email, :pseudo)";

      $bindings = ['id_kinow' => $id_kinow, 'email' => $email, 'pseudo' => $cleanPseudo];

      DB::insert($query, $bindings);

      $id_subscriber = DB::getPdo()->lastInsertId();
    }

    // Create comment row in comment table
    $query = "INSERT INTO comments (id_subscriber_fk, id_film, film_title, content) VALUES (:id_subscriber_fk, :id_film, :film_title, :content)";

    $bindings = ['id_subscriber_fk' => $id_subscriber, 'id_film' => $id_film, 'film_title' => $film_title, 'content' => $cleanContent];

    DB::insert($query, $bindings);

    $id_comment = DB::getPdo()->lastInsertId();

    // Create moderation row in moderation table
    $query = "INSERT INTO moderations (id_comment_fk, id_moderator_fk, status) VALUES (:id_comment_fk, :id_moderator_fk, :status)";

    $bindings = ['id_comment_fk' => $id_comment, 'id_moderator_fk' => 27, 'status' => 'Valide'];

    DB::insert($query, $bindings);

    return true;
  }
}
