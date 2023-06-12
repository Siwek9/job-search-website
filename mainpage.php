<?php
    session_start();
    if (empty($_SESSION['isLogged']) || empty($_SESSION['accountType'])) {
        header("Location:index.php");
        die;
    }
    
    if ($_SESSION['accountType'] != 'employee' && $_SESSION['accountType'] != 'employer') {
        header("Location:index.php");
        die;
    }
    
    header("Location:{$_SESSION['accountType']}-mainpage.php");
    

?>