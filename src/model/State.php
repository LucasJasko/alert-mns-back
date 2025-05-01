<?php

namespace src\model;

use core\model\ModelManager;

class State extends ModelManager
{

  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
