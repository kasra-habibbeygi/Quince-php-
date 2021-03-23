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

        public function logout(){

            if(isset($_SESSION['admin_id'])){

                unset($_SESSION['admin_id']);
                session_destroy();  

            }

        }

        public function getUser(){

            $id = $_SESSION['admin_id'];
            $SQ = "SELECT * FROM `admins` WHERE id = '$id'";
            $result = $this -> query($SQ);
            $user = $this -> getRow($result);
            $this -> freeResult($result); 

            return $user;

        }

        public function updateProfile($adminId , $firstname , $lastname , $username , $email , $validphone , $gender){

            // get admin database username
            $admin_info = $this -> getUser();
            $admin_username = $admin_info['username'];
            $admin_email = $admin_info['email'];

            $UQ = "UPDATE `admins` SET firstname = '$firstname' , lastname = '$lastname' , phone = '$validphone' , gender = '$gender'";

            // check admin change username input or not  
            if($username != $admin_username){

                // check database for dont save exist username
                $DB_usernames = "SELECT id FROM `admins` WHERE username = '$username'";
                $DBU_result = $this -> query($DB_usernames);
                $find = $this -> getRow($DBU_result);

                if($find == '')
                    $UQ .= ", username = '$username'";

                else
                    $this -> redirect('?msg=duplicate-username');

            }

            if($email !== $admin_email){

                // check database for dont save exist email
                $DB_email = "SELECT id FROM `admins` WHERE email = '$email'";
                $DBE_result = $this -> query($DB_email);
                $find = $this -> getRow($DBE_result);

                if($find == '')
                    $UQ .= ", email = '$email'";

                else
                    $this -> redirect('?msg=duplicate-email'); 

            }


            $UQ .= "WHERE id = '$adminId'";
            $this -> query($UQ);


        }

    }

?>