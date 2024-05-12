<?php
require_once dirname(__DIR__) . '/app/database/db.class.php';

class ExpenseModel
{
    public function getAllExpensesByUserId($id_user)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $stmt = $db->prepare("SELECT * FROM dz2_expenses WHERE id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Use fetchAll instead of fetch
    }

    public function getUserByUserId($id_user)
    {
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');
        $stmt = $db->prepare("SELECT * FROM dz2_users WHERE id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
