<?php
    if (!isset($_GET['userID'])) {
        header("Location:index.php");
        die;
    }

    if (!is_numeric($_GET['userID'])) {
        header("Location:index.php");
        die;
    }

    $userID = $_GET['userID'];

    require('server/database-functions.php');

    $connect = database_connect_to_mysql();

    if (!$connect) {
        header("Location:index.php");
        die;
    }

    // $stmt = $connect->prepare("SELECT email, id_user_data FROM accounts");
    
    require('account-activation-prompt.html');

?>