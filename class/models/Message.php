<?php

namespace class\models;

class Message
{

  private int $exp;
  private int $dest;
  private string $content;

  public function __construct(int $exp, int $dest) {}
}
