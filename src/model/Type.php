<?php

namespace src\model;

use core\model\ModelManager;

class Type extends ModelManager
{
  private int $id;
  private string $name;

  function __construct($id)
  {
    $row = $this->getModel($id);
  }
}
