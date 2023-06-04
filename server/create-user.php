<?php
    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (!isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password-repeat'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'missing-fields', 'message' => "Niektóre pola są puste.")));
        die;
    } // kill if not all fields are sended

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password-repeat'];

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password-repeat'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'empty-fields', 'message' => "Niektóre pola są puste.")));
        die;
    } // kill if some fields are empty

    $name_regex = '/^(?=.{3,20}$)[a-zA-Z0-9_]+$/';
    $password_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,20}$/';

    $name = htmlentities($name);
    $email = htmlentities($email);

    if (!preg_match($name_regex, $name)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędna nazwa.")));
        die;
    } // check if name overlaps regex
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędny e-mail.")));
        die;
    } // check if email is email

    if ($password != $password_repeat) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'password-not-same', 'message' => "Oba hasła muszą być takie same.")));
        die;
    } // check if passwords are the same
    
    $password_repeat = "";

    if (!preg_match($password_regex, $password)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędne hasło.")));
        die;
    } // check if password overlaps regex

    if ($name == $password) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Nazwa użytkownika i hasło nie mogą być takie same.")));
        die;
    }
    
    $password = hash('sha256', $password);
    
    require('database-functions.php');

    $connect = connect_to_mysql();
    if (!$connect) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }
    
    $name_temp = $connect->real_escape_string($name);
    $email_temp = $connect->real_escape_string($email);
    
    if ($name_temp != $name) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędna nazwa.")));
        die;
    }
    
    if ($email_temp != $email) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędny e-mail.")));
        die;
    }

    // ini_set();


?>