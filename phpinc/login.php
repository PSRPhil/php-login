<?php
    if(isset($_POST["login"])){
	if(User::login($_POST)){
            redirect("main.php");
	}else{
            $message = "Your username or password was incorrect";
	}
    }else{
	$message = "";
    }
?>
<h1>Login</h1>
<?php echo outputMessage($message); ?>
<form id="login-form" name="login" action="" method="post">
    <input class="input" type="text" name="email" autocomplete="off" id="name" placeholder="Email Address" required/>
    <input class="input" type="password" name="pass" id="password" placeholder="Password" required />
    <input class="button" id="submit" name="login" type="submit" value="Login">
</form>