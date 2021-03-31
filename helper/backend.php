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

        public function createCategory($name , $parent){

            $find_id = "SELECT id FROM `category` WHERE id = '$parent'";
            $FI_result = $this -> query($find_id);
            
            if(gettype(mysqli_fetch_assoc($FI_result)) !== 'NULL' || $parent == '0'){

                $creator = $this -> getUser();
                $creator = $creator['username'];
                $CCQ = "INSERT INTO `category` VALUES ('NULL' , '$name' , '$parent' , '$creator')";
                $result = $this -> query($CCQ);
                
                if($result > 0)
                    $this -> redirect('?msg=category-create');

                else
                    $this -> redirect('?msg=create-failed');

            }else{

                $this -> redirect('?msg=create-failed');

            }

        }

        public function deleteCategory(){

            $delete_id = $this -> safeGet('delete-row');
            $delete_id = (int)$delete_id;

            // delete child if parent was deleted
            $S_Q = "SELECT parent_id FROM `category` WHERE id = '$delete_id'";
            $S_result = $this -> query($S_Q);
            $parent_id = mysqli_fetch_assoc($S_result);
            
            if($parent_id['parent_id'] == '0'){

                $D_Q = "DELETE FROM `category` WHERE parent_id = '$delete_id'";
                $this -> query($D_Q);
    
            }

            // delete soome row
            $D_Q = "DELETE FROM `category` WHERE id = '$delete_id'";
            $D_result = $this -> query($D_Q);

            if($D_result > 0)
                $this -> redirect('?msg=delete-confirm');

            else    
                $this -> redirect('?msg=delete-failed');

        }

        public function deleteAllCategory(){

            $delete_all = $this -> safeGet('delete-all');

            // delete child if parent was deleted
            $S_Q = "SELECT * FROM `category` WHERE id IN($delete_all)";
            $S_result = $this -> query($S_Q);

            while($parent_id = mysqli_fetch_assoc($S_result)){

                if($parent_id['parent_id'] == '0'){

                    $id = $parent_id['id'];
                    $DSCA_Q = "DELETE FROM `category` WHERE parent_id = '$id'";
                    $this -> query($DSCA_Q);
       
                }

            }

            // delete all
            $DA_Q = "DELETE FROM `category` WHERE id IN($delete_all)";
            $DA_result = $this -> query($DA_Q);

            if($DA_result)
                $this -> redirect('?msg=delete-confirm');

            else    
                $this -> redirect('?msg=delete-failed');
            
        }

        public function editCategory($E_name , $E_parent , $E_id){

            $creator = $this -> getUser();
            $creator = $creator['username'];
            $update_Q = "UPDATE `category` SET title = '$E_name' , parent_id = '$E_parent' , creator = '$creator' WHERE id = '$E_id'";
            $result = $this -> query($update_Q);
            if($result > 0)
                $this -> redirect('?msg=edit-confirm');
    
            else    
                $this -> redirect('?msg=edit-failed');

        }

    }

?>