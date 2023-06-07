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

  function getAllCommentsBySubscriber(Request $request)
  {
    $id = $request->input('id');
    $result = $this->subscriberRepository->getAllCommentsBySubscriber($id);

    if (count($result) === 0) {
      return response()->json(['No subscriber found.'], 404);
    } else {
      return AppServiceProvider::translateIntoArrayofObjects($result);
    }
  }

  function getPseudo(Request $request)
  {
    $id_kinow = $request->input('idKinow');
    $email = $request->input('email');
    $result = $this->subscriberRepository->getPseudo($id_kinow, $email);

    if (count($result) === 0) {
      return response()->json(['No subscriber found.'], 404);
    } else {
      return $result;
    }
  }

  function modifyPseudo(Request $request)
  {
    $id = $request->input('id');
    $pseudo = $request->input('pseudo');

    // Clean the input from vulnerabilities
    $cleanPseudo = htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8');

    $result = $this->subscriberRepository->modifyPseudo($id, $cleanPseudo);

    if (!$result) {
      return response()->json(['No subscriber found.'], 404);
    } else {
      return response()->json(['Modified successfully.'], 200);
    }
  }

  function alreadyCommented(Request $request)
  {
    $id_kinow = $request->input('idKinow');
    $id_film = $request->input('idFilm');

    $result = $this->subscriberRepository->alreadyCommented($id_kinow, $id_film);

    if (count($result) === 0) {
      return 1;
    } else {
      return 0;
    }
  }

  function createComment(Request $request)
  {

    $id = $request->input('id');

    $content = $request->input('content');
    $email = $request->input('email');
    $pseudo = $request->input('pseudo');
    $id_kinow = $request->input('id_kinow');
    $id_film = $request->input('id_film');
    $film_title = $request->input('film_title');

    // Check if there's a pseudo
    $exists = $this->subscriberRepository->getPseudo($id, $email);

    // Clean the input from vulnerabilities
    $cleanPseudo = htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8');
    $cleanContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    $result = $this->subscriberRepository->createComment($cleanContent, $email, $cleanPseudo, $id_kinow, $id_film, $film_title, $exists);

    if ($result) {
      return response()->json(['Added successfully.'], 200);
    } else {
      return response()->json(['Error.'], 404);
    }
  }
}
