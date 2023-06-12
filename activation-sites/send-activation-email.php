<?php
    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    $userID = $_POST['userID'];

    require('../server/database-functions.php');

    $connect = database_connect_to_mysql();
    
    if (!$connect) {
        header("Location:../index.php");
        die;
    }

    $result = $connect->query("SELECT accounts.email AS email, account_activation.activation_code AS activation_code, account_activation.mail_sended AS mail_sended FROM accounts JOIN account_activation ON account_activation.user_id = accounts.id WHERE accounts.id = $userID");
    $data = $result->fetch_assoc();

    if ($data['activation_code'] == null) {
        header("Location:../index.php");
        die;
    }

    $randomCode = $data['activation_code'];
    
    $result = $connect->query("UPDATE account_activation SET mail_sended = 1 WHERE user_id = $userID");
    if ($result) {
        require('../server/mail-functions.php');
        sendMail($data['email'], "Aktywacja konta JobSE", require("activation-email.php"));
    }


?>