<?php

namespace src\model;

class Message
{

  private int $exp;
  private int $dest;
  private string $content;
  private string $date;
  private string | array $file;

  public function __construct(int $exp, int $dest) {}
}
