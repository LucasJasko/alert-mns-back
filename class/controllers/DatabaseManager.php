<?php

namespace class\controllers;

class DatabaseManager
{

  private \class\core\Database $pdo;

  public function __construct()
  {
    $this->pdo = new \class\core\Database("alertmns");
  }
}
