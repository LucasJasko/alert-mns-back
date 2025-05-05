<?php

namespace Src\Model;

use Src\Model\Model;

class Notif extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
