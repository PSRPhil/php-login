<?php
    function isLoggedIn(){
        if(isset($_SESSION["user"])){
            return true;
        }else{
            return false;
        }
    }
    function outputMessage($message=""){
        if(empty($message)){
            return "";
        }else{
            return "<p>{$message}</p>";	
        }
    }
    function hashString($password){
        $salt = "67gft567FG5Th7dafty23A";
        $passwordSalt = $password . $salt;
        $encrypted = hash("ripemd160", $passwordSalt);
        return $encrypted;
    }
    function redirect($url){
        ob_start();
        header("Location: {$url}");
        ob_end_clean();
    }