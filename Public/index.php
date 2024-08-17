<?php 
    require_once '../Models/DataBase.php';
    require_once '../Controllers/TaskController.php';
    
    $conn = new DataBase();
    $db = $conn->conectar();

    $controller = new TaskController($db);
    $controller->handleRequest();
