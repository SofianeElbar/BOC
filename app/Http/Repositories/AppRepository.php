<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use App\Providers\AppServiceProvider;

class AppRepository
{

  function selectAll()
  {
    $array = DB::select("SELECT * FROM comments");
    // $array = DB::table("comments")->distinct()->get();

    return $array;
  }

  function selectAllJoined()
  {

    // Query

    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk");

    // Translation

    return AppServiceProvider::translateIntoObject($array);
  }

  function selectAllValidated()
  {
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide'");

    return $array;
  }

  function selectAllValidatedByAuthor($id)
  {
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide' OR status = 'Rejete' OR status='A relire' AND id_kinow = $id");

    return AppServiceProvider::translateIntoObject($array);
  }

  function selectAllValidatedByFilm($id)
  {

    // Query

    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide' AND status = 'A relire' AND id_film = $id");

    // Translation

    return AppServiceProvider::translateIntoObject($array);
  }

  function selectAllValidatedByAuthorByFilm($idKinow, $idFilm)
  {
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide' AND id_kinow = $idKinow");

    return AppServiceProvider::translateIntoObject($array);
  }

  function selectFilmById($id)
  {
    // var_dump($id);
    $array = DB::select("SELECT * FROM comments WHERE id_film=$id");

    return $array;
  }

  function selectAuthorsByFilm($id)
  {
    // var_dump($id);
    $array = DB::select("SELECT * FROM subscribers JOIN comments ON comments.id_subscriber_fk=subscribers.id_subscriber WHERE id_kinow=$id");

    return $array;
  }

  function selectPseudoByAuthor($id)
  {

    $array = DB::select("SELECT pseudo FROM subscribers WHERE id_kinow=$id");

    return $array;
  }

  function updatePseudoByAuthor($id, $pseudo)
  {

    $array = DB::select("UPDATE subscribers SET pseudo = '$pseudo' WHERE id_kinow = $id");

    return $array;
  }

  function createNew($request)
  {
    $title = $request["title"];
    $content = $request["content"];
    $email = $request["email"];
    $pseudo = $request["pseudo"];
    $id_kinow = $request["id_kinow"];
    $id_film = $request["id_film"];
    $film_title = $request["film_title"];

    // Pseudo verification

    $result = DB::selectOne("SELECT pseudo FROM subscribers WHERE id_kinow = ?", [$id_kinow]);
    $pseudo_exists = $result ? $result->pseudo : "";

    var_dump($result, $pseudo, $pseudo_exists);

    if ($pseudo === $pseudo_exists) {
      $subscriber_id = DB::selectOne("SELECT id_subscriber FROM subscribers WHERE id_kinow=?", [$id_kinow])->id_subscriber;
    } else {

      $subscriber = DB::insert("INSERT INTO subscribers (id_kinow, email, pseudo) VALUES (?, ?, ?)", [$id_kinow, $email, $pseudo]);

      $subscriber_id = DB::getPdo()->lastInsertId();
    }

    $comment = DB::insert("INSERT INTO comments (id_subscriber_fk, id_film, film_title, title, content) VALUES (?, ?, ?, ?, ?)", [$subscriber_id, $id_film, $film_title, $title, $content]);

    $comment_id = DB::getPdo()->lastInsertId();

    $moderation = DB::insert("INSERT INTO moderations (id_comment_fk, id_moderator_fk, status) VALUES (?, ?, ?)", [$comment_id, 27, 'Valide']);

    return "Added successfully";
  }

  function deleteCurrent($id)
  {
    $array = DB::select("DELETE FROM comments WHERE id_comment=$id");

    return "Removed successfully";
  }

  function changeCurrent($id)
  {
    $array = DB::select("UPDATE moderations SET status = (CASE WHEN status = 0 THEN 1 ELSE 0 END) WHERE moderations.id_comment_fk = $id");

    return "Update successfully";
  }

  function moderateCurrent($id)
  {
    $array = DB::select("UPDATE moderations SET status = 'A relire' WHERE moderations.id_comment_fk = $id");

    return "Update successfully";
  }

  function validateCurrent($id)
  {
    $array = DB::select("UPDATE moderations SET status = 'Valide' WHERE moderations.id_comment_fk = $id");

    return "Update successfully";
  }

  function rejectCurrent($id)
  {
    $array = DB::select("UPDATE moderations SET status = 'Rejete' WHERE moderations.id_comment_fk = $id");

    return "Update successfully";
  }
}
