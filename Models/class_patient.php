<?php 
require_once 'abs_class_users.php';
    class patient extends users{

        public function __construct(){
            $this->role='patient';
         }
        public function setId($value_id){
            $this->id=$value_id;
        }
        public function setName($value_name){
            $this->name=$value_name;
        }
        public function setPassword($value_password){
            $this->password=$value_password;
        }
       
        public function setEmail($value_email){
            $this->email=$value_email;
        }

        public function hashPassword($password):string{
           return password_hash($password, PASSWORD_BCRYPT);
        }

        

        public function check_user_by_Email():bool{
            $con= new con_mysql();
            $pdo= $con->connect();
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$this->email]);
            $user = $stmt->fetch();

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["role"] = $user["role"];
                $this->role=$user["role"];
                $this->name=$user["name"];
                $this->id=$user["id"];

                return true;
            } else {
                $error = "Email ou mot de passe incorrect.";
                return false;
            }
            
        }

    }
?>