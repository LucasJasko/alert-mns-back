<?php

namespace Core\Controller;

class Auth
{
  protected static $accessKey;

  public static function protect()
  {
    self::initSession();


    if (!isset($_SESSION["access_key"])) {
      \Src\App::redirect("login");
      exit();
    }

    ob_start();
    require ROOT . "/config/env/publickey.crt";
    $key = ob_get_contents();
    ob_end_clean();

    try {
      $decoded = \Firebase\JWT\JWT::decode($_SESSION["access_key"], new \Firebase\JWT\Key($key, "RS256"));
    } catch (\Exception $e) {
      \Src\App::redirect("login");
      exit();
    }
  }

  public static function initSession()
  {
    self::isSession() ? "" : session_start();
  }

  public static function isSession()
  {
    return session_status() == 2 ? true : false;
  }

  public static function setAccessToken(array $data)
  {
    if (self::isSession() && !isset($_SESSION["access_key"])) {

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
        "data" => [
          "une" => "superdata",
        ]
      ];

      self::$accessKey = \Firebase\JWT\JWT::encode($payload, $key, "RS256");
      $_SESSION["access_key"] = self::$accessKey;
    }
  }

  public static function sessionToken()
  {
    return $_SESSION["access_key"];
  }

  public static function setDeleteToken()
  {
    if (self::isSession() && !isset($_SESSION["delete_key"])) {
      $_SESSION["delete_key"] = bin2hex(random_bytes(32));
    }
  }
  public static function deleteToken()
  {
    return isset($_SESSION["delete_key"]) ? $_SESSION["delete_key"] : "";
  }
}
