<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

// Include the configuration file
require_once BASE_PATH . '../../config.php';

// Include necessary files
require_once BASE_PATH . '../Database.php';
require_once BASE_PATH . 'ProyectManager.php';
require_once BASE_PATH . 'Proyect.php';

// Create an instance of ProyectManager
$ProyectManager = new ProyectManager();

// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

// Handle different actions
switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyect = new Proyect($_POST);
            $ProyectManager->createProyects($proyect);
            header('Location: ' . BASE_URL);
            exit;
        }
        require BASE_PATH . '../../views/task_form.php';
        break;
    case 'delete':
        $ProyectManager->deleteProyects($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    default:
        $proyects = $ProyectManager->getAllProyects();
        print($proyects);
        exit();
       # require BASE_PATH . '../../views/task_list.php';
        break;
}