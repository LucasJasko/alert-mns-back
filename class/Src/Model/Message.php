<?php

namespace Src\Model;

use Src\Model\Model;

class Message extends Model
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
