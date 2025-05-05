<?php

namespace Src\Model;

use Src\Model\Model;

class Room extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
