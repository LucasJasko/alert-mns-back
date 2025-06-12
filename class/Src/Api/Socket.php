<?php

namespace Src\Api;

use \Src\App;

class Socket
{

  private static string $address = "0.0.0.0";
  private static int $port = 8060;
  private static $null = null;

  public static function new_socket()
  {

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($sock, self::$address, self::$port);
    socket_listen($sock);

    echo "Le serveur écoute le sur le port " . self::$port . "\n";

    $members = [];
    $connections[] = $sock;

    while (true) {
      $reads = $connections;
      $writes = $exceptions = self::$null;

      socket_select($reads, $writes, $exceptions, 0);

      if (in_array($sock, $reads, 0)) {
        $new_connections = socket_accept($sock);

        $header = socket_read($new_connections, 1024);
        self::handshake($header, $new_connections, self::$address, self::$port);

        $connections[] = $new_connections;
        $reply = "Vous avez rejoins la discussion. \n";
        $reply = self::pack_data($reply);

        socket_write($new_connections, $reply, strlen($reply));

        $sock_index = array_search($sock, $reads);
        unset($reads[$sock_index]);
      }

      foreach ($reads as $key => $value) {
        $data = socket_read($value, 1024);

        if (!empty($data)) {
          // Donc il y a un nouveau message du client, il faut donc l'écrire à tous les clients connectés

          $message = self::unmask($data);
          $masked_message = self::pack_data($message);

          foreach ($connections as $ckey => $cvalue) {
            // Le premier client connecté au serveur est le serveur lui même ! pour ne pas envoyer les réponses au serveur il faut passer la première connection au serveur
            if ($ckey === 0)
              continue;

            socket_write($cvalue, $masked_message, strlen($masked_message));

          }

        } else if ($data === '') {
          // $data est censé retourner '' contrairement à la documentation qui indique false

          echo "Le client " . $key . " s'est déconnecté \n";
          unset($connections[$key]);
          socket_close($value);
        }
      }

    }

    socket_close($sock);

  }

  private static function unmask($text)
  {
    // La recommandation RFC6455 stipule qu'un payload doit avoir une longueur de 7 bits, on doit donc effectuer la conversion de 8 à 7.
    $length = @ord($text[1]) & 127;

    if ($length == 126) {
      $masks = substr($text, 4, 4);
      $data = substr($text, 8);
    } else if ($length == 127) {
      $masks = substr($text, 10, 4);
      $data = substr($text, 14);
    } else {
      $masks = substr($text, 2, 4);
      $data = substr($text, 6);
    }
    $text = "";

    for ($i = 0; $i < strlen($data); ++$i) {
      $text .= $data[$i] ^ $masks[$i % 4];
    }

    return $text;
  }

  private static function pack_data($text)
  {
    // Ici b1 représente le premier byte du payload (1 byte = 8 bits), qui est constitué de FIN, RSV1, RSV2, RSV3 et Opcode sur les 4 bits restants
    // 0x80 = 128, 0x1 = 1, 0x0f = 15
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125) {
      $header = pack("CC", $b1, $length);
    } else if ($length > 125 && $length < 65536) {
      $header = pack("CCn", $b1, 126, $length);
    } else if ($length >= 65536) {
      $header = pack("CCNN", $b1, 127, $length);
    }
    return $header . $text;

  }

  private static function handshake($request_header, $sock, $address, $port)
  {
    $headers = [];
    $lines = preg_split("/\r\n/", $request_header);

    foreach ($lines as $line) {
      $line = chop($line);
      if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
        $headers[$matches[1]] = $matches[2];
      }
    }

    $sec_key = $headers['Sec-WebSocket-Key'];
    $sec_accept = base64_encode(pack('H*', sha1($sec_key . "258EAFA5-E914-47DA-95CA-C5AB0DC85B11")));
    $response_header = "HTTP/1.1 101 Switching Protocols\r\n" . "Upgrade: websocket\r\n" . "Connection: Upgrade\r\n" . "Sec-WebSocket-Accept:$sec_accept\r\n\r\n";

    socket_write($sock, $response_header, strlen($response_header));
  }
}