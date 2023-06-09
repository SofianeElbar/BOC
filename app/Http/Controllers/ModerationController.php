<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Http\Repositories\ModerationRepository;

class ModerationController extends BaseController
{

  protected ModerationRepository $moderationRepository;

  public function __construct(ModerationRepository $moderationRepository)
  {
    $this->moderationRepository = $moderationRepository;
  }

  function moderateComment($id)
  {

    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->moderationRepository->moderateComment($id);
    }

    if (!$result) {
      return response()->json(['error'], 404);
    } else {
      return response()->json(['success' => 'Status modified.'], 200);
    }
  }

  function validateComment($id)
  {

    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->moderationRepository->validateComment($id);
    }

    if (!$result) {
      return response()->json(['error'], 404);
    } else {
      return response()->json(['success' => 'Status modified.'], 200);
    }
  }

  function rejectComment($id)
  {

    if (!$id || !is_numeric($id)) {
      return response()->json(['error' => 'Invalid argument.'], 404);
    } else {
      $result = $this->moderationRepository->rejectComment($id);
    }

    if (!$result) {
      return response()->json(['error'], 404);
    } else {
      return response()->json(['success' => 'Status modified.'], 200);
    }
  }
}
