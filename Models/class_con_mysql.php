<?php 
    require_once 'int_connexion.php';
    class con_mysql implements connexion{
        private  string $host;
        private string $dbname;
        private string $username;
        private string  $password;

        public function __construct(){
            $this->host = "localhost";
            $this->dbname = "appointment_system";
            $this->username = "root"; // Modifier si nécessaire
            $this->password = ""; // Modifier si nécessaire
        }
       
        public function connect():PDO{

            try {
                $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
                return null;
            }
        }     

    }
?>