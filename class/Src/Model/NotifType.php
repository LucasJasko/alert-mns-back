<?php

namespace Src\Model;

use Src\Model\Model;

class NotifType extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
