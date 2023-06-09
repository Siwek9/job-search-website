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

    $result 

    // $stmt = $connect->prepare("SELECT email, id_user_data FROM accounts WHERE id = ?");
    // $stmt->bind_param('i', $userID);
    // $stmt->execute();

    // $stmt->store_result();
    
    // if ($stmt->num_rows() == 0) {
    //     header("Location:../index.php");
    //     die;
    // } // check if user even exists
    
    // $stmt->execute();
    // $result = $stmt->get_result();

    // $data = $result->fetch_assoc(); // get user data

    // $stmtIsCodeSended = $connect->prepare("SELECT * FROM account_activation WHERE user_id = ?");
    // $stmtIsCodeSended->bind_param("i", $userID);
    // $stmtIsCodeSended->execute();
    // $stmtIsCodeSended->store_result();
    // // check if code was generated
    
    // // if no generate it and send it
    
    // if ($stmtIsCodeSended->num_rows() == 0) {
    //     $randomCode = bin2hex(random_bytes(16));
    //     $stmtCreateCode = $connect->prepare("INSERT INTO account_activation(user_id, activation_code, expiration_time) VALUES (?,?,DATE_ADD(NOW(), INTERVAL 2 MINUTE))");
    //     $stmtCreateCode->bind_param('is', $userID, $randomCode);
    //     $stmtCreateCode->execute();
        
    //     require('../server/mail-functions.php');
    //     sendMail($data['email'], "Aktywacja konta JobSE", require("activation-email.php"));
    // }
    // else {
    //     $stmtIsCodeSended->execute();
    //     $result = $stmtIsCodeSended->get_result();

    //     $randomCode = $result->fetch_assoc()['activation_code'];
    // }

    // WARN: this is TEMPORARY for demo use because email don't want always to come to different email adressess than from 'onet.poczta.pl'
    // this should be deleted when own smtp server will be created
    // echo "job-search-website/activation-sites/account-activated.php?userID=$userID&activationCode=$randomCode";

    // display website
    require_once('account-activation-prompt.html');


    
?>