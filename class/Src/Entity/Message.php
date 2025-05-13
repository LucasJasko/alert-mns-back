<?php

namespace Src\Entity;

class Message extends \Src\Model\Model
{

  private int $exp;
  private int $dest;
  private string $content;
  private string $date;
  private string | array $file;

  public function __construct($id)
  {
    $row = $this->getDBModel($id)[0];
  }
}
