<?php
require_once __DIR__ . '/libraryservice.class.php';

class KalodontController
{
    private $libraryService;

    public function __construct()
    {
        $this->libraryService = new LibraryService();
        //session_start(); // Start the session
    }

    public function handleRequest()
    {
        $kalodonti = [];
        $igre = $this->libraryService->getAllDistinctIgra();
        $selectedIgra = isset($_SESSION['vrsta_igre']) ? $_SESSION['vrsta_igre'] : '';
        $selectedKolodonti = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['odabir_akcije'])) {
                $selectedAction = $_POST['odabir_akcije'];

                if ($selectedAction === 'igra' && isset($_POST['vrsta_igre'])) {
                    $selectedIgra = htmlspecialchars($_POST['vrsta_igre']);
                    $_SESSION['vrsta_igre'] = $selectedIgra; // Store vrsta_igre in session
                    $kalodonti = $this->libraryService->getAllIgraFromKalodonti($selectedIgra);

                    // Debugging: Print retrieved kalodonti data
                    echo '<pre>';
                    print_r($kalodonti);
                    echo '</pre>';
                } elseif ($selectedAction === 'diskvalifikacija' && isset($_POST['selected_kolodonti'])) {
                    $selectedKolodonti = $_POST['selected_kolodonti'];
                    // Handle disqualification logic here
                }
            }
        }

        return compact('kalodonti', 'igre', 'selectedIgra', 'selectedKolodonti');
    }
}

// Instantiate and handle the request
$controller = new KalodontController();
$data = $controller->handleRequest();
