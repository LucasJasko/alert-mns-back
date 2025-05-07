<?php

namespace Core\Controller;

abstract class Controller
{

  protected $db;

  public function __construct()
  {
    $this->db = \Src\App::db();
  }
}
