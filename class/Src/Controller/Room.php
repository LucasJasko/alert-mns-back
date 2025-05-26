<?php

namespace Src\Controller;

use Src\Model\Entity\Room as RoomModel;

class Room extends \Src\Controller\Controller
{
  private $roomInstance;
  public $formInfos;

  public function __construct()
  {
    parent::__construct();
    $this->formInfos = RoomModel::formInfos();
  }

  public function dispatch($group_id, $room_id, bool $isApi = false)
  {

    if ($isApi) {
      // Process API
      return;
    }

    \Src\Auth\Auth::protect();


    if (isset($room_id) && isset($group_id)) {

      if ($_POST) {
        $room = new RoomModel($room_id);
        $room->submitData($_POST);
        \Src\App::redirect("group");
      }

      if ($room_id != 0) {
        $this->getModelForm("room", $room_id, $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
        return;
      }

      $this->getEmptyModelForm("room", $this->formInfos, "room/" . $group_id . "/" . $room_id, $group_id);
    }
  }
}