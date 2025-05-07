<?php

namespace Core\Controller;

class Controller
{

  protected $db;

  function __construct()
  {
    $this->db = \Src\App::db();
  }
}
