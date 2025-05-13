<?php

namespace Src\Entity;

class Notif extends \Src\Model\Model
{
  function __construct($id)
  {
    $row = $this->getDBModel($id)[0];
  }
}
