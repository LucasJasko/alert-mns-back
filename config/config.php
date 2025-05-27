<?php

define("ROOT", dirname(__DIR__));

define("DB_HOST", "localhost");
define("DB_NAME", "speak");
define("DB_USER", "root");
define("DB_PASS", "");

define("PAGE_LIST", [
  "group",
  "user",
  "params",
  "stats",
  "login"
]);

define("JWT_SECRET_KEY", "tropbetepourtrouver");

define("VENDORS", [
  "Firebase\JWT\JWT" => ROOT . "\\vendor\\firebase\php-jwt\src\JWT.php",
  "Firebase\JWT\Key" => ROOT . "\\vendor\\firebase\php-jwt\src\Key.php"
]);