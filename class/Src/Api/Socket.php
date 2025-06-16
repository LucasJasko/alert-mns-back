<?php

namespace Src\Api;

class Socket
{
  private $socketServer;
  private array $connections;
  private array $members;
  private string $address = "0.0.0.0";
  private int $port = 8060;

  public function dispatch($isApi = false)
  {

    if ($isApi) {

      \Src\App::sendApiData(\Src\Api\Auth::protect());

    }

  }

  // TODO créer une méthode de ping, qui vérifie si l'utilisateur est toujours présent, et déconnextion du socket si non

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
    $this->members = [];
    $this->connections[] = $sock;

    while (true) {
      $reads = $this->connections;
      $writes = $exceptions = null;

      socket_select($reads, $writes, $exceptions, 0);

      $this->acceptNewConnections($sock, $reads);
      $this->handleIncomingMessage($reads);

    }
  }

  private function acceptNewConnections($sock, $reads)
  {
    if (in_array($sock, $reads, 0)) {
      $new_connections = socket_accept($sock);

      $header = socket_read($new_connections, 1024);
      $this->handshake($header, $new_connections, $this->address, $this->port);

      $this->connections[] = $new_connections;

      echo "Nouvelle connection \n";

      $reply = [
        "messageInfos" => [
          "date" => date("d M Y - H:i:s"),
          "type" => "join",
          "sender" => "Server",
        ],
        "authorName" => "Server",
        "authorMessage" => [
          "messageText" => "Vous avez rejoins la discussion",
        ]
      ];

      $reply = $this->pack_data(json_encode($reply));

      socket_write($new_connections, $reply, strlen($reply));

      $sock_index = array_search($sock, $reads);
      unset($reads[$sock_index]);
    }
  }

  private function handleIncomingMessage($reads)
  {
    foreach ($reads as $key => $sock) {

      if ($sock === $this->socketServer) {
        continue;
      }

      $data = socket_read($sock, 1024);

      if (!empty($data)) {
        // Il y a un nouveau message de client, il faut l'envoyer à tous les clients connectés

        $message = $this->unmask($data);

        $decoded_message = json_decode($message, true);

        // TODO TRES IMPORTANT !! ajouter une vérification du format de message avant envoie (pour éviter les éventuelles modifications intermédiaires donc htmlspecialchars sur les champs modifiables)

        if ($decoded_message && isset($decoded_message["messageInfos"]["type"])) {

          $type = $decoded_message["messageInfos"]["type"];


          $decoded_message["authorMessage"]["messageText"] = htmlspecialchars($decoded_message["authorMessage"]["messageText"] ?? '');

          if ($type == "join") {
            $this->members[$key] = [
              "name" => $decoded_message["messageInfos"]["sender"],
              "connection" => $sock
            ];
          }

          if ($type == "message") {
            var_dump($type);
            // TODO problème ici on rentre bien dans la boucle mais le contenu ne s'exécute pas
            $masked_message = $this->pack_data($message);

            foreach ($this->members as $mkey => $mvalue) {
              socket_write($mvalue["connection"], $masked_message, strlen($masked_message));
            }

          }
        }


      } else if ($data === '' || !$data) {

        echo "Le client " . $key . " s'est déconnecté \n";
        unset($this->connections[$key]);

        if (array_key_exists($key, $this->members)) {
          $message = [
            "messageInfos" => [
              "date" => date("d M Y - H:i:s"),
              "type" => "left",
              "sender" => "Server",
            ],
            "authorName" => "Server",
            "authorMessage" => [
              "messageText" => $this->members[$key]["name"] . " A quitté la discussion",
            ]
          ];

          $masked_message = $this->pack_data(json_encode($message));
          unset($this->members[$key]);

          foreach ($this->members as $mkey => $mvalue) {
            socket_write($mvalue["connection"], $masked_message, strlen($masked_message));
          }
        }

        socket_close($sock);
      }
    }
  }

  /**
   * la fonction unmask permet de "décoder" le message reçu en concordance avec la recommandation RCF6455
   * @param mixed $text
   * @return string
   */
  private function unmask($payload)
  {
    // La recommandation RFC6455 stipule qu'un payload doit avoir une longueur de 7 bits, on doit donc effectuer la conversion de 8 à 7.
    $length = @ord($payload[1]) & 127;

    if ($length == 126) {
      $masks = substr($payload, 4, 4);
      $data = substr($payload, 8);
    } else if ($length == 127) {
      $masks = substr($payload, 10, 4);
      $data = substr($payload, 14);
    } else {
      $masks = substr($payload, 2, 4);
      $data = substr($payload, 6);
    }

    $unmasked = "";
    for ($i = 0; $i < strlen($data); ++$i) {
      $unmasked .= $data[$i] ^ $masks[$i % 4];
    }

    return $unmasked;
  }

  /**
   * pack_data adosse au message reçu un header contenant sa longueur binaire en chaine de caratères en concordance avec les recommandations RFC
   * @param mixed $text
   * @return string
   */
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
      $header = pack("CCNN", $b1, 127, 0, $length);
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

    if (!isset($headers['Sec-WebSocket-Key'])) {
      socket_close($sock);
      return;
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