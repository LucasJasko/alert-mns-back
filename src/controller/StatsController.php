<?php

namespace src\controller;

class StatsController
{
  public function getView()
  {
    require str_replace("/public", "", $_SERVER["DOCUMENT_ROOT"]) . "/src/pages/stats.php";
  }
}
