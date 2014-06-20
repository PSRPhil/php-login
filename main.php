<?php require_once('phpinc/initialise.php'); ?>
<?php 
    if(!isLoggedIn()){
        redirect('index.php');
    }
?>
<?php require_once('htmlinc/head.php'); ?>

<a href="phpinc/logout.php">Sign out</a>

<?php require_once('htmlinc/footer.php'); ?>