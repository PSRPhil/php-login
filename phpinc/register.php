<?php @require_once("phpinc/initialise.php"); ?>

<?php
    if(isLoggedIn()){
        redirect("main.php");
    }
?>

<?php
    if(isset($_POST["register"])){
        $errors = array();
        if(empty($_POST["email"])){
            $errors = "You have not entered an email";
        }
        if(empty($_POST["username"])){
            $errors = "You have not entered a username";
        }
        if(empty($_POST["pass"])){
            $errors = "You have not entered a password";
        }
        if($_POST["pass"] != $_POST["confirmpass"]){
            $errors = "The passwords you entered did not match";
        }
        if(empty($errors)){
            if(!User::checkUsernameAvailable($_POST["username"])){
                $errors = "An account with this username already exists";
            }else if(!User::checkEmailAvailable($_POST["email"])){
                $errors = "An account is already registered with this E-mail address.";
            }else{
                if(User::register($_POST)){
                    $registered = "Your account has successfully been registered! You are now able to sign in.";
                }else{
                    $errors = "There was an error creating this user";	
                }	
            }
        }
    }
?>

<h1>Registration</h1>
<?php echo outputMessage($errors); ?>
<?php echo outputMessage($registered); ?>
<form id="register-user" name="register" action="" method="post">
    <input type="email" name="email" autocomplete="off" id="name" placeholder="E-Mail Address" required/>
    <input type="text" name="username" id="username" placeholder="Username" required />
    <input type="password" name="pass" id="password" placeholder="Password" required />
    <input type="password" name="confirmpass" id="confirmpassword" placeholder="Confirm Password" required />
    <input class="button" id="submit" name="register" type="submit" value="Register">
</form>

