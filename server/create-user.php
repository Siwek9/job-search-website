<?php
    $request_method = $_SERVER['REQUEST_METHOD'];
    
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['repeat-password'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'missing-fields', 'message' => "Brak wszystkich pól.")));
        die;
    } // kill if not all fields are sended

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password-repeat'];

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['repeat-password'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'empty-fields', 'message' => "Niektóre pola są puste.")));
        die;
    } // kill if some fields are empty

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

    }




?>