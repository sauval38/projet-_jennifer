<?php 

namespace AdminModels;

use PDO;
use App\Database;

class AdminAboutMeModels {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection(); 
    }

    public function fetchAboutMeData() {
        $query = "SELECT * FROM about_me"; 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function fetchAboutMeDataById($id) {
        $stmt = $this->db->prepare("SELECT * FROM about_me WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAboutMe($id, $bio, $imagePath, $text_1, $text_2, $text_3) {
        $stmt = $this->db->prepare("UPDATE about_me SET bio = :bio, image_path = :image_path, text_1 = :text_1, text_2 = :text_2, text_3 = :text_3 WHERE id = :id");
        return $stmt->execute([
            ':bio' => $bio,
            ':image_path' => $imagePath,
            ':text_1' => $text_1,
            ':text_2' => $text_2,
            ':text_3' => $text_3,
            ':id' => $id
        ]);
    }
}


