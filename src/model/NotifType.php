<?php

namespace src\model;

use core\model\ModelManager;

class NotifType extends ModelManager
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
