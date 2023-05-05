<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

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
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk");

    return $array;
  }

  function selectAllValidated()
  {
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide'");

    return $array;
  }

  function selectAuthorById($id)
  {
    // var_dump($id);
    $array = DB::select("SELECT * FROM comments WHERE id_subscriber_fk = $id");

    return $array;
  }

  function selectAllValidatedByFilm($id)
  {
    $array = DB::select("SELECT * FROM comments JOIN moderations ON moderations.id_comment_fk=comments.id_comment JOIN subscribers ON subscribers.id_subscriber=comments.id_subscriber_fk WHERE status = 'Valide' AND id_film = $id");

    return $array;
  }

  function selectFilmById($id)
  {
    // var_dump($id);
    $array = DB::select("SELECT * FROM comments WHERE id_film=$id");

    return $array;
  }

  function createNew($request)
  {
    $title = $request["title"];
    $content = $request["content"];
    $pseudo = $request["pseudo"];
    $id_film = $request["id_film"];

    $subscriber = DB::insert("INSERT INTO subscribers (id_kinow, pseudo) VALUES (?, ?)", [10, $pseudo]);

    $subscriber_id = DB::getPdo()->lastInsertId();

    $comment = DB::insert("INSERT INTO comments (id_subscriber_fk, id_film, title, content) VALUES (?, ?, ?, ?)", [$subscriber_id, $id_film, $title, $content]);

    $comment_id = DB::getPdo()->lastInsertId();

    $moderation = DB::insert("INSERT INTO moderations (id_comment_fk, id_moderator_fk, status) VALUES (?, ?, ?)", [$comment_id, 27, 'A moderer']);

    return "Added successfully";
  }

  function deleteCurrent($id)
  {
    $array = DB::select("DELETE FROM comments WHERE id_comment=$id");

    return "Removed successfully";
  }
}
