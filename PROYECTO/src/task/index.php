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
require_once BASE_PATH . 'TaskManager.php';
require_once BASE_PATH . 'Task.php';

// Create an instance of TaskManager
$taskManager = new TaskManager();

// Get the action from the URL, default to 'list' if not set
$action = $_GET['action'] ?? 'list';

// Handle different actions
switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task($_POST);
            $taskManager->createTask($task);
            header('Location: ' . BASE_URL . "/task");
            exit;
        }
        require BASE_PATH . '../../views/task_form.php';
        break;
    case 'toggle':
        $taskManager->toggleTask($_GET['id']);
        header('Location: ' . BASE_URL);
        break;
    case 'delete':
        $taskManager->deleteTask($_GET['id']);
        header('Location: ' . BASE_URL . "/task");
        break;
    default:
        $tasks = $taskManager->getAllTasks();
        require BASE_PATH . '/views/list.php';
        break;
}