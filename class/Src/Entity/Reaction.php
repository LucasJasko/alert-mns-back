<?php

namespace Src\Entity;

use Src\Model\Model;

class Reaction extends Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
