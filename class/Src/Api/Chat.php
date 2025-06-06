<?php

namespace Src\Api;

use \Src\App;

class Chat
{
  public function dispatch($isApi)
  {
    \Src\Api\Auth::protect();

    $req = App::getApiData();

    if ($isReal = App::db()->getOneWhere("profile", "profile_id", $req["target"])) {
      // TODO Ici à terme vérifier si l'utilisateur cible n'a pas bloqué l'utilisateur à l'origine de la requête

      if (empty(App::db()->getDmBetweeenAandB("dm", "profile_id_A", $req["target"], "profile_id_B", $req["origin"]))) {

        (new \Src\Model\Entity\Dm("0"))->submitModel(["dm_id" => "", "dm_creation_time" => "", "profile_id_A" => $req["target"], "profile_id_B" => $req["origin"], "state_id" => 1]);

        App::sendApiData("created");

      } else {
        // TODO Envoyer à terme ici les infos du dm
        App::sendApiData("existing");
      }

    } else {
      App::sendApiData("target is not a user");
    }

  }
}