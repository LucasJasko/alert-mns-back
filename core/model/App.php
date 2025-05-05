<?php

namespace core\model;

class App
{

  public function run()
  {
    // header("Location:" . __DIR__ . "../../pages/index.php");
  }

  public function userSearch()
  {
    \core\controller\Auth::getClientAccess();
    $db = new Database();
    $data        = json_decode(file_get_contents("php://input"), true);
    $inputSearch = $data['search'];

    if ($inputSearch & $inputSearch) {
      // $stmt = $db->prepare("SELECT user_name FROM user WHERE user_name LIKE :search");
      //   $stmt->bindValue(":search", "%" . htmlspecialchars($inputSearch) . "%");
      //   $stmt->execute();
      //   if ($row = $stmt->fetchAll()) {
      //     echo json_encode($row);
      //   } else {
      //     echo json_encode("Aucun résultats trouvés");
      //   }
      // } else {
      //   echo json_encode("");
    }
  }
}
