<?php
    session_start();
    // echo "Dypa";
    // die;
    if (!empty($_SESSION['isLogged'])) {
        session_destroy();
        // need to destroy cookies
    } 

    $request_method = $_SERVER['REQUEST_METHOD'];

    if ($request_method == 'GET') {
        header("Location:../index.php");
        die;
    }
    else if ($request_method == 'POST') {
        echo json_encode(array('success' => true));
        die;
    } // reject all bad method
    else {
        die;
    }
?>