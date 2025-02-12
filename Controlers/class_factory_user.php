<?php 
require_once 'Models/abs_class_users.php';
require_once 'Models/class_patient.php';
require_once 'Models/class_doctor.php';
    class factoryUser extends users{

        public function __construct($email,$password){
            $this->email= $email;
            $this->password=  $password;
        }
        public function createUser(){
           
            if($this->check_user()){
                if($this->role="patient"){
                    return new patient();
                }else if ($this->role="doctor"){
                    return new doctor();
                }
            }else{
                return null;
            }
            
        }
    }
?>