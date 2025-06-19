<?php

namespace Src\Api;

use \Src\App;

class Chat
{
  public function dispatch($action, $isApi)
  {

    if ($isApi) {

      if (!\Src\Api\Auth::protect()) {
        http_response_code(403);
        exit();
      }

      switch ($action) {

        case "select":
          $req = App::getApiData();

          if ($targetProfile = App::db()->getOneWhere("profile", "profile_id", $req["target"])) {
            // TODO Ici à terme vérifier si l'utilisateur cible n'a pas bloqué l'utilisateur à l'origine de la requête

            if (empty(App::db()->getDmBetweeenAandB("dm", "profile_id_A", $req["target"], "profile_id_B", $req["origin"]))) {

              (new \Src\Model\Entity\Dm("0"))->submitModel(["dm_id" => "", "dm_creation_time" => "", "profile_id_A" => $req["target"], "profile_id_B" => $req["origin"], "state_id" => 1]);

              unset($targetProfile["profile_password"]);
              unset($targetProfile["profile_mail"]);
              unset($targetProfile["theme_id"]);
              unset($targetProfile["language_id"]);

              unset($targetProfile["profile_password"]);
              unset($targetProfile["profile_mail"]);
              unset($targetProfile["theme_id"]);
              unset($targetProfile["language_id"]);

              $targetProfile["creation"] = $targetProfile["profile_creation_time"];
              unset($targetProfile["profile_creation_time"]);

              $targetProfile["id"] = $targetProfile["profile_id"];
              unset($targetProfile["profile_id"]);

              $targetProfile["name"] = $targetProfile["profile_name"];
              unset($targetProfile["profile_name"]);

              $targetProfile["picture"] = $targetProfile["profile_picture"];
              unset($targetProfile["profile_picture"]);

              $targetProfile["surname"] = $targetProfile["profile_surname"];
              unset($targetProfile["profile_surname"]);

              $targetProfile["role"] = $targetProfile["role_id"];
              unset($targetProfile["role_id"]);

              $targetProfile["status"] = $targetProfile["status_id"];
              unset($targetProfile["status_id"]);

              App::sendApiData($targetProfile);

            } else {
              // TODO Envoyer à terme ici les infos du dm
              http_response_code(204);
            }

          } else {
            App::sendApiData("La cible n'est pas un utilisateur");
          }

          break;

        case "remove":
          //  TODO gérer la suppression d'une conversation privée
          break;


        case "message":

          $message = App::getApiData();

          App::sendApiData($message);

          break;
      }

    } else {
      http_response_code(400);
    }
  }
}