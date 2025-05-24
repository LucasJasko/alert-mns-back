<?php

namespace Core\Controller;

abstract class Auth
{
  public static function initSession()
  {
    self::isSession() ? "" : session_start();
  }
  public static function isSession()
  {
    return session_status() == 2 ? true : false;
  }
  public static function generateDeleteToken()
  {
    return bin2hex(random_bytes(32));
  }
  public static function sessionDeleteToken()
  {
    return isset($_SESSION["delete_key"]) ? $_SESSION["delete_key"] : "";
  }
  public static function newJWToken(array $data)
  {

    ob_start();
    require ROOT . "/config/env/privatekey.pem";
    $key = ob_get_contents();
    ob_end_clean();

    $issuedAt = time();
    $payload = [
      "iss" => "lienapi",
      "aud" => "lienapi",
      "iat" => $issuedAt,
      "nbf" => $issuedAt,
      "data" => $data
    ];

    return \Firebase\JWT\JWT::encode($payload, $key, "RS256");

  }

}
