<?php

require_once '../models/Task.php';

class TaskController {
    private $db;
    private $task;

    public function __construct($db) {
        $this->db = $db;
        $this->task = new Task($db);
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getTask($id);
                } else {
                    $this->getAllTasks();
                }
                break;
            case 'POST':
                $this->createTask();
                break;
            case 'PUT':
                $this->updateTask($id);
                break;
            case 'DELETE':
                $this->deleteTask($id);
                break;
            default:
                $this->sendResponse(405, 'Method Not Allowed');
        }
    }

    private function getAllTasks() {
        $tasks = $this->task->getAllTasks()->fetchAll(PDO::FETCH_ASSOC);
        $this->sendResponse(200, $tasks);
    }

    private function getTask($id) {
        $task = $this->task->getTask($id);
        if ($task) {
            $this->sendResponse(200, $task);
        } else {
            $this->sendResponse(404, 'Task not found');
        }
    }

    private function createTask() {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validación de los datos
        if (!isset($data['title']) || !isset($data['description'])) {
            $this->sendResponse(400, 'Title and description are required');
            return;
        }

        // Asignar un valor por defecto a status si no está presente
        $status = isset($data['status']) ? $data['status'] : 'pending';

        // Crear la tarea
        if ($this->task->createTask($data['title'], $data['description'], $status)) {
            $this->sendResponse(201, 'Task created successfully');
        } else {
            $this->sendResponse(500, 'Failed to create task');
        }
    }


    private function updateTask($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->task->updateTask($id, $data['title'], $data['description'], $data['status'])) {
            $this->sendResponse(200, 'Task updated successfully');
        } else {
            $this->sendResponse(500, 'Failed to update task');
        }
    }

    private function deleteTask($id) {
        if ($this->task->deleteTask($id)) {
            $this->sendResponse(200, 'Task deleted successfully');
        } else {
            $this->sendResponse(500, 'Failed to delete task');
        }
    }

    private function sendResponse($status, $data) {
        http_response_code($status);
        echo json_encode($data);
    }
}
