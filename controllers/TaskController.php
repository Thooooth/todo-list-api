<?php
require_once '../models/Task.php';
require_once '../utils/Response.php';
require_once '../utils/Validator.php';

class TaskController {
    private $db;
    private $task;

    public function __construct($db) {
        $this->db = $db;
        $this->task = new Task($db);
    }

    public function createTask($data) {
        if(!empty($data->user_id) && !empty($data->title) && !empty($data->status)) {
            $this->task->user_id = Validator::sanitizeString($data->user_id);
            $this->task->title = Validator::sanitizeString($data->title);
            $this->task->description = Validator::sanitizeString($data->description);
            $this->task->status = Validator::sanitizeString($data->status);

            if($this->task->create()) {
                return Response::json(201, "Tarefa criada com sucesso.");
            } else {
                return Response::json(503, "Não foi possível criar a tarefa.");
            }
        } else {
            return Response::json(400, "Não foi possível criar a tarefa. Dados incompletos.");
        }
    }

    public function getTask($id, $user_id) {
        $task = $this->task->read($id);
        if ($task) {
            if ($task['user_id'] == $user_id) {
                return Response::json(200, "Tarefa encontrada", $task);
            } else {
                return Response::json(403, "Acesso negado");
            }
        } else {
            return Response::json(404, "Tarefa não encontrada");
        }
    }

    public function getTasks($user_id) {
        $tasks = $this->task->readByUser($user_id);
        return Response::json(200, "Lista de tarefas recuperada com sucesso", $tasks);
    }

    public function updateTask($data, $user_id) {
        if(!empty($data->id)) {
            $task = $this->task->read($data->id);
            if ($task && $task['user_id'] == $user_id) {
                // ... (lógica de atualização existente) ...
            } else {
                return Response::json(403, "Acesso negado");
            }
        } else {
            return Response::json(400, "ID da tarefa não fornecido");
        }
    }

    public function deleteTask($id, $user_id) {
        $task = $this->task->read($id);
        if ($task) {
            if ($task['user_id'] == $user_id) {
                if($this->task->delete($id)) {
                    return Response::json(200, "Tarefa excluída com sucesso");
                } else {
                    return Response::json(503, "Não foi possível excluir a tarefa");
                }
            } else {
                return Response::json(403, "Acesso negado");
            }
        } else {
            return Response::json(404, "Tarefa não encontrada");
        }
    }

    public function getTasksByUser($user_id) {
        if(!empty($user_id)) {
            $tasks = $this->task->readByUser($user_id);
            return Response::json(200, "Tarefas do usuário recuperadas com sucesso.", $tasks);
        } else {
            return Response::json(400, "Não foi possível recuperar as tarefas. ID do usuário não fornecido.");
        }
    }
}