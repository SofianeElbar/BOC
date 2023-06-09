<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class SubscriberRepository
{

  function sanitizeInput($input)
  {
    $sanitizedInput = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $sanitizedInput;
  }

  function getAllCommentsBySubscriber($id)
  {

    $query = "SELECT * FROM comments 
              JOIN moderations ON moderations.id_comment_fk=comments.id_comment 
              JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE id_kinow = :id";

    $bindings = ['id' => $id];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function getPseudo($id_kinow)
  {

    $query = "SELECT pseudo FROM subscribers WHERE id_kinow = :id_kinow";

    $bindings = ['id_kinow' => $id_kinow];

    $array = DB::select($query, $bindings);

    return $array;
  }

  function modifyPseudo($id, $pseudo)
  {

    $cleanPseudo = $this->sanitizeInput($pseudo);

    $query = "UPDATE subscribers SET pseudo = :pseudo WHERE id_kinow = :id";

    $bindings = ['id' => $id, 'pseudo' => $cleanPseudo];

    $array = DB::update($query, $bindings);

    return $array > 0;
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

    return (bool) $array;
  }

  function getSubscriberDatabaseId($id_kinow)
  {
    $query = "SELECT id_subscriber FROM subscribers WHERE id_kinow = :id_kinow";

    $bindings = ['id_kinow' => $id_kinow];

    $id_subscriber = DB::selectOne($query, $bindings);

    return $id_subscriber ? $id_subscriber->id_subscriber : null;
  }

  function createSubscriberInDatabase($id_kinow, $email, $pseudo)
  {

    $cleanPseudo = $this->sanitizeInput($pseudo);

    $query = "INSERT INTO subscribers (id_kinow, email, pseudo) VALUES (:id_kinow, :email, :pseudo)";

    $bindings = ['id_kinow' => $id_kinow, 'email' => $email, 'pseudo' => $cleanPseudo];

    $array = DB::insert($query, $bindings);

    return 'Added successfully.';
  }
}
