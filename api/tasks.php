<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../controllers/TaskController.php';
require_once '../middleware/AuthMiddleware.php';

$database = new Database();
$db = $database->getConnection();

$taskController = new TaskController($db);

$user_id = AuthMiddleware::authenticate();

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            echo $taskController->getTask($_GET['id'], $user_id);
        } else {
            echo $taskController->getTasks($user_id);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $data->user_id = $user_id;
        echo $taskController->createTask($data);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        echo $taskController->updateTask($data, $user_id);
        break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id === null) {
            echo Response::json(400, "ID da tarefa não fornecido");
        } else {
            echo $taskController->deleteTask($id, $user_id);
        }
        break;
    default:
        echo Response::json(405, "Método não permitido");
        break;
}