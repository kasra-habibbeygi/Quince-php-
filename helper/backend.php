<?php

    defined("DB_HOST")
        or die;

    class Backend extends Base {

        // check login authentication
        public function checkLogin(){

            if(isset($_SESSION['admin_id']))
                return true;

            else    
                return false;

        }        
        
        // login 
        public function login($email , $pass){

            $SQ = "SELECT id FROM `admins` WHERE status = '1' AND email = '$email' AND password = '$pass'";
            $result = $this -> query($SQ);
            $user =  mysqli_fetch_assoc($result);
            $this -> freeResult($result); 

            if(isset($user['id'])){

                $_SESSION['admin_id'] = $user['id'];
                return true;

            }else{

                return false;

            }

        }
      
    }

?>