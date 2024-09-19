<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$userController = new UserController($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        echo $userController->getUsers($id);
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->action) && $data->action === 'login') {
            echo $userController->login($data);
        } else {
            echo $userController->createUser($data);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        echo $userController->updateUser($data);
        break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id === null) {
            echo Response::json(400, "ID do usuário não fornecido");
        } else {
            echo $userController->deleteUser($id);
        }
        break;
    default:
        echo Response::json(405, "Método não permitido");
        break;
}