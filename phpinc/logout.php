<?php
require_once('initialise.php');

if($user = new User($_SESSION["user"])){
    $user->logout();
    redirect("../index.php");
}else{
    redirect("../index.php");
}
