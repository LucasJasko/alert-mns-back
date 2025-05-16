<?php

namespace Src\Entity;

class Reaction extends \Src\Model\Model
{
  function __construct(int $id)
  {
    $row = $this->getDBModel($id);
  }
}
