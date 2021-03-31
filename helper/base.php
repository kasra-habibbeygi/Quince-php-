<?php

    defined("DB_HOST")
        or die;

    abstract  class Base {

        private $dblink = null;

        // connect to db
        public function __construct(){

            $this -> dblink = mysqli_connect(DB_HOST , DB_USERNAME , DB_PASSWORD)
                or die(mysqli_connect_error());

            mysqli_select_db($this -> dblink , DB_NAME)
                or die($this -> getError());

                $this -> query("SET NAMES 'UTF-8'");

        }

        // disconect form db
        public function __destruct(){

            if(is_resource($this -> dblink))
                mysqli_close($this -> dblink);

        }

        // get db conection error
        public function getError(){

            return mysqli_connect_error($this -> dblink);

        }

        // query object
        public function query($q){

            $result = mysqli_query($this -> dblink , $q);

            if(stristr($q , 'INSERT'))
                return mysqli_insert_id($this ->dblink);

            else if(stristr($q , 'UPDATE') || stristr($q , 'DELETE'))
                return mysqli_affected_rows($this -> dblink);
            
            else 
                return $result;

        }
        
        public function getRow($val){

            return mysqli_fetch_assoc($val);

        }

        // redirect
        public function redirect($url){

            header("location:$url");
            die;

        }

        // get method
        public function safeGet($val){

            return isset($_GET[$val]) ? htmlentities(trim($_GET[$val]) , ENT_QUOTES , 'UTF-8') : '' ;
            
        }

        // post method
        public function safePost($val){

            return isset($_POST[$val]) ? htmlentities(trim($_POST[$val]) , ENT_QUOTES , 'UTF-8') : '' ;
            
        }

        // change password to sha1 , md5 and base64
        public function safePassword($pass){

            return sha1(md5(base64_encode($pass)));

        }

        public function freeResult($result){

            return mysqli_free_result($result); 

        }

        public function validEmail($val){

            return filter_var($val , FILTER_VALIDATE_EMAIL);

        }

        public function validphone($val){

            return filter_var($val, FILTER_SANITIZE_NUMBER_INT);

        }

        public function uploadFile($input , $path , $allowtypes , $admin_id){

            $error = $_FILES[$input]['error'];
            if($error == 0){

                $fielName = mb_strtolower($_FILES[$input]['name'] , 'UTF-8');
                $fileType = pathinfo($fielName ,  PATHINFO_EXTENSION);
                $isAllow = array_search($fileType , $allowtypes);
                

                if($isAllow === false){

                        return "type_denied";

                }else{

                    $temp = $_FILES[$input]['tmp_name'];
                    $newFileName = md5(date('YmdHis').mt_rand(1 , 9999)).'.'.$allowtypes[$isAllow];
                    $result = move_uploaded_file($temp , "$path/$newFileName");

                    if($result){

                        $UQ = "UPDATE `admins` SET avatar = '$newFileName' WHERE id = '$admin_id'";
                        $result = $this -> query($UQ);

                        if($result > 0)
                            return $newFileName;

                        else 
                            return "DB_error";

                    }


                    else 
                        return "update_error2";

                }

            }else {

                return "upload_error";

            }

        }

    }

?>