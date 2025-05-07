<?php

namespace Src\Controller;

class Controller extends \Core\Controller\Controller
{
  public function getAvailableId($table, $field)
  {
    $res = $this->db->getField($table, $field);
    $id = 1;
    $notFound = true;
    while ($notFound) {
      for ($i = 0; $i < count($res); $i++) {
        if ($id == $res[$i][$field]) {
          $id += 1;
        } else {
          $notFound = false;
          return $id;
        }
      }
    }
  }
}
