<?php

namespace controllers;

use core\Database;

class GroupManager
{

  private $db;


  public function __construct()
  {
    $this->db = new Database();
  }
}
