<?php

namespace Src\Controller;

use Src\Entity\Room as RoomModel;

class Room extends \Src\Controller\Controller
{
  private $roomInstance;
  public $formInfos;

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = RoomModel::formInfos();
  }

  public function dispatch($group_id, $room_id, bool $isApi = false, bool $isDelete = false)
  {

    var_dump($group_id);
    var_dump($room_id);

    if ($_POST) {
      $this->submitData($_POST);
      // \Src\App::redirect("group/" . $group_id);
    }

    if ($room_id != 0) {
      $this->getModelForm("room", $room_id, $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
    } else {
      $this->getEmptyModelForm("room", $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
    }
  }

  // CETTE METHODE FAIT CRASH LE SERVEUR...
  public function submitData(array $data)
  {
    var_dump($data);
    // if (empty($data["room_id"]) || $data["room_id"] == "0") {
    //   $data["room_id"] = $this->getAvailableId("room", "room_id");

    //   $this->roomInstance = new RoomModel($data["room_id"], $data);
    //   $this->roomInstance->createNewModel("room", $data);
    // } else {
    //   $this->roomInstance = new RoomModel($data["room_id"]);
    //   $this->roomInstance->updateModel($data["room_id"], $data);
    // }
  }
}