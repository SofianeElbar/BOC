<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

class ModerationRepository
{

  function moderateComment($id)
  {

    $query = "UPDATE moderations SET status = :relire WHERE id_comment_fk = :id";

    $bindings = ['relire' => 'A relire', 'id' => $id];

    $array = DB::update($query, $bindings);

    return (bool) $array;
  }

  function validateComment($id)
  {

    $query = "UPDATE moderations SET status = :valide WHERE id_comment_fk = :id";

    $bindings = ['valide' => 'Valide', 'id' => $id];

    $array = DB::update($query, $bindings);

    return (bool) $array;
  }

  function rejectComment($id)
  {

    $query = "UPDATE moderations SET status = :rejete WHERE id_comment_fk = :id";

    $bindings = ['rejete' => 'Rejete', 'id' => $id];

    $array = DB::update($query, $bindings);

    return (bool) $array;
  }
}
