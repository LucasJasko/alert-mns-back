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

  public function dispatch($group_id, $room_id, $del, bool $isApi = false)
  {

    if ($isApi) {
      // Process API
    } else {

      if ($_POST) {
        $this->submitData($_POST);
        \Src\App::redirect("group");
      }

      if ($room_id != 0) {

        $room = new RoomModel($room_id);

        if ($del == $_SESSION["delete_key"]) {

          $res = $room->deleteModel();

          if ($res) {
            \Src\App::redirect("error");
          }
          \Src\App::redirect("group");

        } else {
          $this->getModelForm("room", $room_id, $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
        }
      } else {
        $this->getEmptyModelForm("room", $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
      }
    }
  }

  public function submitData(array $data)
  {
    if (empty($data["room_id"]) || $data["room_id"] == "0") {
      $data["room_id"] = $this->getAvailableId("room", "room_id");

      $this->roomInstance = new RoomModel($data["room_id"], $data);
      $this->roomInstance->createNewModel("room", $data);
    } else {
      $this->roomInstance = new RoomModel($data["room_id"]);
      $this->roomInstance->updateModel($data["room_id"], $data);
    }
  }
}