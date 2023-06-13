<?php
    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'empty-fields', 'message' => "Niektóre pola są puste.")));
        die;
    } // kill if some fields are empty

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptcha = $_POST['g-recaptcha-response'];
    if (isset($_POST['rememberMe'])) {
        $rememberMe = $_POST['rememberMe'];
    }
    else {
        $rememberMe = "off";
    }
    
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
    
    $username = $connect->real_escape_string($username);
    $email = $connect->real_escape_string($email);

    $result = $connect->query("SELECT id, account_type FROM accounts WHERE name LIKE '$username' AND email LIKE '$email' AND password LIKE '$password_hashed'");
    if (!$result) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'mysql_error', 'message' => "Wystąpił błąd po stronie serwera. Proszę spróbować ponownie za kilka minut.")));
        die;
    }
    
    if ($result->num_rows == 0) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Nie istnieje konto z podanymi danymi.")));
        die;    
    }

    $userData = $result->fetch_assoc();

    session_start();
    session_regenerate_id();
    $_SESSION['isLogged'] = true;
    $_SESSION['userID'] = $userData['id'];
    $_SESSION['accountType'] = $userData['account_type'];

    if ($rememberMe == "on") {
        // remember me stuff
    }

    echo json_encode(array('success' => true));

    function verify_captcha($recaptcha, $secret) {
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret . '&response=' . $recaptcha;
        $response = file_get_contents($url);
        $response = json_decode($response);

        return $response->success;
    }
?>