<?php 
    class Task {
        private $conn;
        private $table = 'tasks';

        public function __construct(){

        }

        public function getAllTasks () {
            $query = "SELECT * FROM" . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }

        public function getTask($id){
            $query = "SELECT * FROM " . $this->table . "WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id',$id);
            $stmt->execute;
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function createTask($title, $description, $status) {
            $query = "INSERT INTO " . $this->table . " (title, description, status, created_at) VALUES (:title, :description, :status, CURRENT_TIMESTAMP)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        }

        public function updateTask ($id,$title,$descripcion,$status){
            $query = "UPTADE". $this->table . "SET title= :title, descripcion , status = :status WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id' ,$id);
            $stmt->bindParam(':title' , $title);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':status' ,$status);

            return $stmt->execute();

        }

        public function deleteTask ($id){
            $query = "DELETE FROM" . $this->table . "WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

    }