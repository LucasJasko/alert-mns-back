<?php

namespace Src\Entity;

use Src\Model\Model;

class Notif extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
