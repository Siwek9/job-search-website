<?php
    if (!isset($_GET['userID'])) {
        header("Location:../index.php");
        die;
    }

    if (!is_numeric($_GET['userID'])) {
        header("Location:../index.php");
        die;
    }
    
    $userID = $_GET['userID'];
    
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
    
    if (!$data["mail_sended"]) {
        $result = $connect->query("UPDATE account_activation SET mail_sended = 1 WHERE user_id = $userID");
        if ($result) {
            require('../server/mail-functions.php');
            sendMail($data['email'], "Aktywacja konta JobSE", require("activation-email.php"));
        }
    }
    
    // WARN: this is TEMPORARY for demo use because email don't want always to come to different email adressess than from 'onet.poczta.pl'
    // this should be deleted when own smtp server will be created
    echo "job-search-website/activation-sites/account-activated.php?userID=$userID&activationCode=$randomCode";
    
    // display website
    require_once('account-activation-prompt.html');
    
    
    
?>