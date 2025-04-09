<?php

namespace controllers;

use models\User;

class UserManager
{

  public $db;
  private static $instance;
  private $userList = [];

  private function __construct() {}

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new UserManager();
    }
    return self::$instance;
  }

  public function getUser()
  {
    $this->db = "yes";
  }

  public function createUser(int $uid = null) {}

  public function updateUser(string $target, string $value) {}
}
