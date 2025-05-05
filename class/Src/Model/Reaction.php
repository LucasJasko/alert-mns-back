<?php

namespace Src\Model;

use Src\Model\Model;

class Reaction extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
