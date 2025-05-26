<?php

namespace Src\Controller;

class Stats extends \Src\Controller\Controller
{
  public function dispatch(bool $isApi)
  {

    if ($isApi) {
      // Process API
      return;
    }

    \Src\Auth\Auth::protect();
    $this->getView();
  }

  public function getView()
  {
    require ROOT . "/pages/stats.php";
  }


}
