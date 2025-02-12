<?php 
    require_once('class_con_mysql.php');
    abstract class users{
        protected int $id;
        protected string $name;
        protected string $email;
        protected string $password;
        protected string $role;
      
        public function registre():bool{
            $con= new con_mysql();
            $pdo= $con->connect();

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$this->name, $this->email, $this->password, $this->role])) {
               return true;
            } else {
                $error = "Erreur lors de l'inscription.";
                return false;
            }
        }
        public function check_user():bool{
            $con= new con_mysql();
            $pdo= $con->connect();
            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$this->email]);
            $user = $stmt->fetch();

            if ($user && password_verify($this->password, $user["password"])) {
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