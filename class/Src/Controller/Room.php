<?php

namespace Src\Controller;

use Src\Entity\Room as RoomModel;

class Room extends \Src\Controller\Controller
{
  private $roomInstance;
  public $formInfos;

  // TODO voir pourquoi la soumission du formulaire renvoie vers group et non vers room

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = RoomModel::formInfos();
  }

  public function dispatch($group_id, $room_id, bool $isApi = false, bool $isDelete = false)
  {

    if ($_POST) {
      $this->submitData($_POST);
      \Src\App::redirect("group/" . $group_id);
    }

    if ($room_id != 0) {
      $this->getModelForm("room", $room_id, $this->formInfos, "group/" . $group_id);
    } else {
      $this->getEmptyModelForm("room", $this->formInfos, "group/" . $group_id);
    }
  }

  public function submitData(array $data)
  {
    var_dump($data);
    if (empty($data["room_id"])) {
      $availableId = $this->getAvailableId("room", "room_id");
      $data["room_id"] = $availableId;

      $this->roomInstance = new RoomModel($data["room_id"], $data);
      $this->roomInstance->createNewModel("room", $data);
    } else {

      $this->roomInstance = new RoomModel($data["room_id"]);
      $this->roomInstance->updateModel($data["room_id"], $data);
    }
  }
}