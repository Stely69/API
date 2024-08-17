<?php 
    class DataBase{
        private $host = "localhost";
        private $name = "mi_base_de_datos";
        private $user = "root";
        private $password = "";
        public $conn;


        public function __construct() {
            $this->conectar();
        }

        public function conectar(){
            try {
                $this->conn = new PDO("mysql:host=". $this->host . ";name=" . $this->name , $this->user , $this->password);
            }catch(PDOException $e){
                echo "Error de conxecion" . $e->getMessage();
            }

            return $this->conn;
        }
    }