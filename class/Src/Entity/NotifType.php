<?php

namespace Src\Entity;

class NotifType extends \Src\Model\Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
