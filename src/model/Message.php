<?php

namespace src\model;

use core\model\ModelManager;

class Message extends ModelManager
{

  private int $exp;
  private int $dest;
  private string $content;
  private string $date;
  private string | array $file;

  public function __construct($id)
  {
    $row = $this->getDBModel($id);
  }
}
