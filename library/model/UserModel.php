<?php
require_once dirname(__DIR__) . '/app/database/db.class.php';

class UserModel
{
    public function getUserByUsername($username)
    {
        $db = DB::getConnection();
        $stmt = $db->prepare("SELECT * FROM dz2_users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>