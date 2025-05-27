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

      $room = new RoomModel($room_id);

      if ($_POST) {
        $room->submitModel($_POST);
        \Src\App::redirect("group");
      }

      if ($room_id != 0) {

        $form = new \Src\Model\Form("room", "room/$room_id", $this->formInfos, $group_id);
        $form->getForm($room->all(), "Modification du salon $room_id", "room");
        return;
      }

      //  unset($formInfos[$modelName . "_id"]);
      $form = new \Src\Model\Form("room", "room/$group_id/0", $this->formInfos, $group_id);

      $fieldsOfTable = $this->db->getFieldsOfTable("room");
      $fieldsOfTable = array_fill_keys($fieldsOfTable, "");

      $form->getEmptyForm($fieldsOfTable, "Création d'un nouveau salon", "group/$group_id", ["room_id"]);
    }
  }
}