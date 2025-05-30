<?php

namespace Src\Database;

class Database extends \Core\Database\Database
{

  public function getAllRelationsBetween()
  {
  }

  public function getPicture($table, $target, $field, $value): mixed
  {
    $sql = "SELECT $target FROM `$table` WHERE $field = :$field AND $target IS NOT NULL AND $target <> ''";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":$field", $value);
    $stmt->execute();
    return $stmt->fetch();
  }

  public function getResultsThatContain($table, array $searched, $target, $target2, $value)
  {
    $sql = "SELECT ";
    for ($i = 0; $i < count($searched); $i++) {
      if ($i < count($searched) - 1) {
        $sql .= $searched[$i] . ", ";
      } else {
        $sql .= $searched[$i];
      }
    }
    $sql .= " FROM `$table` WHERE $target LIKE CONCAT('%', :query, '%') OR $target2 LIKE CONCAT('%', :query, '%')";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":query", $value);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function setPicture($table, $target, $field, $targetValue, $fieldValue)
  {
    $sql = "UPDATE `$table` SET $target = :$target WHERE $field = :$field";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":$target", $targetValue);
    $stmt->bindValue(":$field", $fieldValue);
    $stmt->execute();
  }
}
