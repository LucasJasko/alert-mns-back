<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWToken
{
  private $secretKey;
  private $method;

  public function __construct()
  {
    $this->secretKey = "Mon ptit gr@in de sel";
    $this->method = 'HSC256';
  }

  public function genToken(int $uID): string
  {
    $payload = [
      'iss' => "alert-mns",
      'aud' => "alert-mns",
      'iat' => time(),
      'exp' => time() + 3600,
      'sub' => $uID
    ];
    return JWT::encode($payload, $this->secretKey, $this->method);
  }

  public function verifyToken(string $token)
  {
    try {
      $headers = new stdClass();
      return JWT::decode($token, new Key($this->secretKey, $this->method), $headers);
    } catch (Exception $error) {
      return $error->getMessage();
    }
  }
}
