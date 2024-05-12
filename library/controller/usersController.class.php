<?php 

require_once __DIR__ . '/../model/libraryservice.class.php';

class UsersController
{
	public function index() 
	{
		$ls = new LibraryService();

		$title = 'Popis svih korisnika knjižnice';
		$userList = $ls->getAllUsers();

		require_once __DIR__ . '/../view/users_index.php';
	}

	public function history()
	{
		if (isset($_GET['id_user'])) {
			$userId = $_GET['id_user'];

			$ls = new LibraryService();
			$userExpenses = $ls->getAllExpensesByUserId($userId);
			$partExpenses = $ls ->getAllPartsByUserId($userId);

			require_once __DIR__ . '/../view/user_expenses.php';
		}
	}

}; 

?>
