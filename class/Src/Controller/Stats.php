<?php

namespace Src\Controller;

class Stats extends \Src\Controller\Controller
{
  public function getView()
  {
    require ROOT . "/pages/stats.php";
  }
}
