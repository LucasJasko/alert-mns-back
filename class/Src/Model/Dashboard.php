<?php

namespace Src\Model;

class Dashboard
{

  public function __construct(string $tableName, array $data, array $dashboardInfos, array $exceptions = [])
  {
    $page = isset($_GET["page"]) ? $_GET["page"] : "";
    $tab = $tableName;
    $fields = $dashboardInfos;


  }

}
