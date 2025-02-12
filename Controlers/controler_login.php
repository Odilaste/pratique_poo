<?php 
    require 'Models/class_con_mysql.php';
    require 'class_factory_user.php';
class Controler_login{
    public static $error = "";
   public static function login(){
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $login_user= new factoryUser( $email,$password );
            $user=$login_user->createUser();
            if(! $user){
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
                header("Location: Views/view_login.php");
                exit;
            }
            else{
                header("Location: Views/view_dashboard.php");
                exit;
            }

        }
        else {
            $error ="";
            include("Views/view_login.php");
        }
   }

   public static function logout(){
      
       session_destroy();
       header("Location:../Views/view_login.php");

   }
}
   
?>