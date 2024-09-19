<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../controllers/TaskController.php';

$database = new Database();
$db = $database->getConnection();

$taskController = new TaskController($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Implementar getTasks()
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        echo $taskController->createTask($data);
        break;
    case 'PUT':
        // Implementar updateTask()
        break;
    case 'DELETE':
        // Implementar deleteTask()
        break;
    default:
        echo Response::json(405, "Method not allowed");
        break;
}
