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
    $account_type = $_POST['account-type'];
    $recaptcha = $_POST['g-recaptcha-response'];

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
    } // check if the name isn't the same as password

    if ($account_type != 'employee' && $account_type != 'employer') {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Zły typ konta.")));
        die;
    } // check if form output correct account type

    $secret_key = '6LfxKWgmAAAAAMKyNuozldz2jW98FwZ6u1Ri3aTw';

    if (!verify_captcha($recaptcha, $secret_key)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'recaptcha', 'message' => "Brak potwierdzenia reCaptcha.")));
        die;
    } // check correct captcha
    
    $password_hashed = hash('sha256', $password);
    
    require('database-functions.php');

    $connect = database_connect_to_mysql();
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
    try {
        if (database_name_exists($connect, $name)) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'data-not-unique', 'message' => "Ta nazwa jest zajęta. Proszę spróbować inną.")));
            die;
        } // check if the name is used
    
        if (database_email_exists($connect, $email)) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'data-not-unique', 'message' => "Podany adres email jest zajęty.")));
            die;
        } // check if the email is used
    }
    catch(Exception $e) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Wystąpił błąd przy połączeniu z serwerem. Prosimy spróbować ponownie za kilka minut.")));
        die;
    }

    $randomCode = bin2hex(random_bytes(16));
    $resultArray = array();
    // creating account
    if (!($resultArray = database_transaction($connect, 
            array(
                "INSERT INTO accounts(name, email, password, account_type) VALUES ('$name','$email','$password_hashed','$account_type')",
                "INSERT INTO account_activation(user_id, activation_code, expiration_time) VALUES (
                    (SELECT accounts.id FROM accounts WHERE name LIKE '$name' AND email LIKE '$email' LIMIT 1),
                    '$randomCode', 
                    DATE_ADD(NOW(), INTERVAL 2 MINUTE)
                )",
                "SELECT id FROM accounts WHERE name LIKE '$name' AND email LIKE '$email'"
            )
        )
    )) 
    {
        echo json_encode(array('success' => false, 'error' => array('type' => 'mysql_error', 'message' => "Wystąpił błąd po stronie serwera. Proszę spróbować ponownie za kilka minut.")));
        die;
        
    }

    $userData = $resultArray[2]->fetch_assoc();

    if(!isset($userData['id'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'mysql_error', 'message' => "Wystąpił błąd po stronie serwera. Proszę spróbować ponownie za kilka minut.")));
        die;
    }

    $connect->close();
    echo json_encode(array('success' => true, 'accountID' => $userData['id']));
    die;

    function verify_captcha($recaptcha, $secret) {
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret . '&response=' . $recaptcha;
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }
?>