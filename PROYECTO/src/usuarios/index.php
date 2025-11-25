<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the base path for includes
define('BASE_PATH', __DIR__ . '/');

// Include the configuration file
require_once BASE_PATH . '../../config.php';

// Include necessary files
require_once BASE_PATH . '../Database.php';
require_once BASE_PATH . 'UsersManager.php';
require_once BASE_PATH . 'Users.php';

// Create an instance of UsersManager
$usersManager = new UserManager();

// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

// Handle different actions
switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usersManager->createUser($_POST['title'],$_POST['description']);
            header('Location: ' . BASE_URL);
            exit;
        }
        require BASE_PATH . '../../views/task_form.php';
        break;
    case 'delete':
        $usersManager->deleteUser($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    default:
        $users = $usersManager->getAllUsers();
        require BASE_PATH . 'views/task_list.php';
        break;
}