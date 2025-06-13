<?php

namespace Src\Api;

class Socket
{
  private $socketServer;
  private array $connections;
  private string $address = "0.0.0.0";
  private int $port = 8060;

  public function dispatch($isApi = false)
  {

    if ($isApi) {

      \Src\App::sendApiData(\Src\Api\Auth::protect());

    }

  }

  public function lauchSocketServer()
  {

    $this->initaliseSocketServer();
    $this->listenForNewConnections($this->socketServer);

  }

  private function initaliseSocketServer()
  {

    if ($this->socketServer === null) {

      $this->socketServer = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      socket_bind($this->socketServer, $this->address, $this->port);
      socket_listen($this->socketServer);

      echo "Le serveur écoute sur le port " . $this->port . "\n";

    }

  }

  private function listenForNewConnections($sock)
  {
    $members = [];
    $this->connections[] = $sock;

    while (true) {
      $reads = $this->connections;
      $writes = $exceptions = null;

      socket_select($reads, $writes, $exceptions, 0);

      $this->acceptNewConnections($sock, $reads);
      $this->handleIncomingMessage($reads, $this->connections);

    }
  }

  private function handleIncomingMessage($reads, $connections)
  {
    foreach ($reads as $key => $sock) {

      if ($sock === $this->socketServer) {
        continue;
      }

      $data = socket_read($sock, 1024, PHP_NORMAL_READ);

      if (!empty($data)) {
        // Il y a un nouveau message de client, il faut l'envoyer à tous les clients connectés

        $message = $this->unmask($data);
        $masked_message = $this->pack_data($message);
        $this->broadcastMessage($connections, $masked_message);

      } else if ($data === '') {

        echo "Le client " . $key . " s'est déconnecté \n";
        unset($this->connections[$key]);
        socket_close($sock);

      }
    }
  }

  private function broadcastMessage($connections, $masked_message)
  {
    foreach ($connections as $ckey => $cvalue) {
      // Le premier client connecté au serveur est le serveur lui même ! pour ne pas envoyer les réponses au serveur il faut passer la première connection au serveur
      if ($ckey === 0)
        continue;

      socket_write($cvalue, $masked_message, strlen($masked_message));

    }
  }

  private function acceptNewConnections($sock, $reads)
  {
    if (in_array($sock, $reads, 0)) {
      $new_connections = socket_accept($sock);

      $header = socket_read($new_connections, 1024);
      $this->handshake($header, $new_connections, $this->address, $this->port);

      $this->connections[] = $new_connections;
      $reply = "Vous avez rejoins la discussion. \n";
      echo "Nouvelle connection socket \n";
      print_r($this->connections);
      $reply = $this->pack_data($reply);

      socket_write($new_connections, $reply, strlen($reply));

      $sock_index = array_search($sock, $reads);
      unset($reads[$sock_index]);
    }
  }

  private function unmask($text)
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

  private function pack_data($text)
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

  private function handshake($request_header, $sock, $address, $port)
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
    $response_header =
      "HTTP/1.1 101 Switching Protocols\r\n" .
      "Upgrade: websocket\r\n" .
      "Connection: Upgrade\r\n" .
      "Sec-WebSocket-Accept:$sec_accept\r\n\r\n";

    socket_write($sock, $response_header, strlen($response_header));
  }
}