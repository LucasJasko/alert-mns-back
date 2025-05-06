<?php

namespace Src\Entity;

class Room extends \Src\Model\Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
