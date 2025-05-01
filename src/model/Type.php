<?php

namespace src\model;

use core\model\ModelManager;

class Type extends ModelManager
{

  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
