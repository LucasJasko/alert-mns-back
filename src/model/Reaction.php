<?php

namespace src\model;

use core\model\ModelManager;

class Reaction extends ModelManager
{
  function __construct($id)
  {
    $row = $this->getModel($id);
  }
}
