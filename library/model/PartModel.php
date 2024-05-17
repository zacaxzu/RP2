<?php
require_once dirname(__DIR__) . '/app/database/db.class.php';

class PartModel
{
    public function getAllPartsByUserId($id_user)
    {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM dz2_parts WHERE id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Use fetchAll instead of fetch
    }
}
