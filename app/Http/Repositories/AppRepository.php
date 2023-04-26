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

  function selectById($id)
  {
    // var_dump($id);
    $array = DB::select("SELECT * FROM comments WHERE id_subscriber_fk=$id");

    return $array;
  }

  function createNew($request, $id)
  {
    $title = $request["title"];
    $content = $request["content"];

    $array = DB::select("INSERT INTO comments (id_subscriber_fk, id_film, title, content) VALUES ($id, 1, '$title', '$content')");

    return "Added successfully";
  }

  function deleteCurrent($id)
  {
    $array = DB::select("DELETE FROM comments WHERE id_comment=$id");

    return "Removed successfully";
  }
}
