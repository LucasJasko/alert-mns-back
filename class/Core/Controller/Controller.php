<?php

namespace Core\Controller;

abstract class Controller
{

  protected $db;

  public function __construct()
  {
    $this->db = \Src\App::db();
  }

  public function redirect($page)
  {
    header("Location:./index.php?page=" . $page);
  }
}
