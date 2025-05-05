<?php

namespace src\model;

use core\model\ModelManager;

class Notif extends ModelManager
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
