<?php

// Ce fichier sert à se connecter à la base de données

try {
  $db = new PDO("mysql:host=localhost;dbname=alertmns;charset=utf8", "root", "");
} catch (exception $e) {
  die($e->getMessage());
}