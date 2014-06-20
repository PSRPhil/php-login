<?php
    
    class User{
        public $id;
        public $username;
        private $password;
	public $ipaddress;
        public $created;
	public $lastlogged;
        public $type_id;
        public $email;
        
        function __construct($id=""){
            if(empty($id) || !is_numeric($id)){
                return false;
            }else{
                global $database;
                
                $id = $database->escape_value($id);
                $sql = "SELECT * FROM `user_info` WHERE `user_id`='{$id}'";
                if($result = $database->query($sql)){
                    $result = $database->fetch_assoc($result);
                    
                    $this->id = $result["user_id"];
                    $this->username = $result["username"];
                    $this->password = $result["password"];
                    $this->ip = $result["ipaddress"];
                    $this->created = $result["created"];
                    $this->lastlogged = $result["lastlogged"];
                    $this->type_id = $result["type_id"];
                    $this->email = $result["email"];
                    
                    $sql = "SELECT * FROM `user_type` WHERE `type_id`='{$this->type_id}'";
                    $result = $database->query($sql);
                    $result = $database->fetch_assoc($result);
                    $this->type = $result['type_name'];
    
                    return true;
                }else{
                    return false; 
                }                
            }
        }
        
        public static function register($post = ""){
            if(empty($post)){
                return false;
            }else{
                global $database;
                
                foreach($post as $key=>$value){
                    $post[$key] = $database->escape_value($value);
                }
                $hashedPass = hashString($post["pass"]);
                $ipad = $_SERVER['REMOTE_ADDR'];
                
                $sql = "INSERT INTO `user_info`(`username`,`password`,`ipaddress`,`email`) VALUES ('{$_POST['username']}','{$hashedPass}','{$ipad}','{$_POST['email']}')";
                if($database->query($sql)){
                    return true;
                }else{
                    return false;
                }
            }
        }
		
        public static function login($post=""){
            if(empty($post)){
                return false;
            }else{
                global $database;
                
                foreach($post as $key=>$value){
                    $post[$key] = $database->escape_value($value);
                }
					
                $hashedPass = hashString($post["pass"]);
					
                $sql = "SELECT `user_id`,`email`,`password` FROM `user_info` WHERE `email`='{$post['email']}';";
                $sqlQuery = $database->query($sql);
                if($database->num_rows($sqlQuery) >= 1){
                    $user = $database->fetch_assoc($sqlQuery);
                    if($hashedPass === $user["password"]){
                        $timestamp = date("Y-m-d H:i:s");
                        $ipad = $_SERVER['REMOTE_ADDR'];
                        $sql = "UPDATE `user_info` SET `lastlogged`='{$timestamp}', `ipaddress`='{$ipad}' WHERE `user_id`={$user['user_id']}";
                        $database->query($sql);
                        $_SESSION["user"] = $user["user_id"];
                        return true;
                    }else{
                        return false;	
                    }
                }else{
                    return false;	
                }
            }	
        }
        
        public static function checkUsernameAvailable($username){
            global $database;
            
            $username = $database->escape_value($username);
            
            $sql = "SELECT `username` FROM `user_info` WHERE `username`='{$username}'";
            $result = $database->query($sql);
            if($database->num_rows($result) != 0){
                return false;
            }else{
                return true;
            }
        }
        
        public static function checkEmailAvailable($email){
            global $database;
            
            $email = $database->escape_value($email);
            
            $sql = "SELECT `email` FROM `user_info` WHERE `email`='{$email}'";
            $result = $database->query($sql);
            if($database->num_rows($result) != 0){
                return false;
            }else{
                return true;
            }
        }

        public function logout(){
            session_destroy();
            return true;
        }
    }