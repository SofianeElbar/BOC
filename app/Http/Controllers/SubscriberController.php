<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Http\Repositories\SubscriberRepository;
use App\Providers\AppServiceProvider;

class SubscriberController extends BaseController
{

  protected SubscriberRepository $subscriberRepository;

  public function __construct(SubscriberRepository $subscriberRepository)
  {
    $this->subscriberRepository = $subscriberRepository;
  }

  function getAllCommentsBySubscriber($id)
  {
    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->subscriberRepository->getAllCommentsBySubscriber($id);
    }

    if (count($result) === 0) {
      return response()->json(['error' => 'No comments found for this subscriber.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function getPseudo($id)
  {

    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->subscriberRepository->getPseudo($id);
    }

    if (!$result) {
      return response()->json(['error' => 'No pseudo found.'], 404);
    } else {
      return $result;
    }
  }

  function modifyPseudo(Request $request, $id)
  {

    $pseudo = $request->input('pseudo');

    if (!$id || !$pseudo || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid arguments.'], 404);
    } else {
      $result = $this->subscriberRepository->modifyPseudo($id, $pseudo);
    }

    if (!$result) {
      return response()->json(['error' => 'No subscriber found or same pseudo submitted.'], 404);
    } else {
      return response()->json(['success' => 'Modified successfully.'], 200);
    }
  }

  function alreadyCommented($a, $b)
  {

    if (!$a || !$b || !is_numeric($a) || !is_numeric($b)) {
      return response()->json(['error' => 'Invalid arguments.'], 404);
    } else {
      $result = $this->subscriberRepository->alreadyCommented($a, $b);
    }

    return response()->json((bool) $result);
  }
}
