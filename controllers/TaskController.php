<?php
require_once '../models/Task.php';
require_once '../utils/Response.php';

class TaskController {
    private $db;
    private $task;

    public function __construct($db) {
        $this->db = $db;
        $this->task = new Task($db);
    }

    public function createTask($data) {
        if(!empty($data->user_id) && !empty($data->title) && !empty($data->status)) {
            $this->task->user_id = $data->user_id;
            $this->task->title = $data->title;
            $this->task->description = $data->description;
            $this->task->status = $data->status;

            if($this->task->create()) {
                return Response::json(201, "Task created successfully.");
            } else {
                return Response::json(503, "Unable to create task.");
            }
        } else {
            return Response::json(400, "Unable to create task. Data is incomplete.");
        }
    }

    // Adicione outros métodos como getTasks(), updateTask(), deleteTask() aqui
}
