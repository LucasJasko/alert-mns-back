<?php

namespace Core\Auth;

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
      "iss" => "http://speak/",
      "aud" => "http://speak:3216/auth/",
      "iat" => $issuedAt,
      "nbf" => $issuedAt,
      "data" => $data
    ];

    return \Firebase\JWT\JWT::encode($payload, $key, "RS256", JWT_SECRET_KEY);

  }
  public static function decodeJWT($jwt)
  {
    ob_start();
    require ROOT . "/config/env/publickey.crt";
    $key = ob_get_contents();
    ob_end_clean();

    try {
      return \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key($key, "RS256"));
    } catch (\Exception $e) {
      return $e;
    }
  }
  public function setHttpOnlyCookie($name, $value)
  {
    setcookie(
      $name,
      $value,
      [
        "expires" => time() + 2592000, // 30 jours
        "path" => "/",
        "domain" => "speak",
        "secure" => false,
        "httponly" => true,
        "samesite" => "Strict",
      ]
    );
  }
  public function setCookie($name, $value)
  {
    setcookie(
      $name,
      $value,
      [
        "expires" => time() + 2592000,
        "path" => "/",
        "domain" => "speak",
        "secure" => false,
        "httponly" => false,
        "samesite" => "Strict",
      ]
    );
  }
}
