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

			// Fetch user expenses using the LibraryService
			$ls = new LibraryService();
			$userExpenses = $ls->getAllExpensesByUserId($userId);

			// Initialize an array to store expense descriptions
			$userExpenseDescriptions = [];

			// Loop through each user expense to fetch its description
			foreach ($userExpenses as $expense) {
				// Fetch expense description by expense ID
				$expenseId = $expense->getId(); // Assuming you have a method to get the expense ID
				$expenseDescription = $ls->getExpenseDescriptionByExpenseId($expenseId);

				// Append the expense description to the array, indexed by the expense ID
				$userExpenseDescriptions[$expenseId][] = $expenseDescription;
			}
			// Render the view with the user expenses and their descriptions
			require_once __DIR__ . '/../view/user_expenses.php';
		}
	}

}; 

?>
