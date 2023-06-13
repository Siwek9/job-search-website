<?php
    print_r($_POST);

    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (empty($_POST['firstnameLastname']) || empty($_POST['dateOfBirth']) || empty($_POST['email']) || empty($_POST['nationality'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'missing_fields', 'message' => "Wymagane pola nie mogą być puste.")));
        die;
    } // required fields must be filled in

    session_start();
    if (empty($_SESSION['userID']) || !is_numeric($_SESSION['userID'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'no_permission', 'message' => "Nie możesz zmienić CV.")));
        die;
    }

    $firstName = "";
    $lastName = "";

    $firstAndLastName = explode(' ', $_POST['firstnameLastname']);
    if (count($firstAndLastName) < 2) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Musisz podać poprawne pierwsze imię i nazwisko.")));
        die;
    }
    $firstName = $firstAndLastName[0];
    unset($firstAndLastName[0]);
    $firstAndLastName = array_values($firstAndLastName);
    $lastName = implode(" ", $firstAndLastName);

    $dateOfBirth = $_POST['dateOfBirth'];

    if (!validateDate($dateOfBirth)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawna data urodzenia.")));
        die;
    } // check if data is valid

    $email = $_POST['email'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędny e-mail.")));
        die;
    } // check if email is email

    $nationality = $_POST['nationality'];

    $codes = require('world.php');
    $isNationalityValid = array_search($nationality, array_column($codes, 'alpha2'));

    if(!$isNationalityValid) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędna narodowość.")));
        die;
    }

    $phoneNumber = "";
    if (empty($_POST['phoneNumber'])) {
        $phoneNumber = 'NULL';
    }
    else if (validatePhoneNumber($_POST['phoneNumber'])) {
        $phoneNumber = "'{$_POST['phoneNumber']}'";
    }
    else {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawny numer telefonu.")));
        die;
    }

    $photoName = "";
    $tempName = "";
    if (empty($_FILES['photo']['tmp_name'])) {
        $photoName = "NULL";
    }
    else if (isPhoto($_FILES['photo']['tmp_name'])) {
        $tempName = $_FILES['photo']['tmp_name'];

        $file_ext = pathinfo($_FILES['photo']['name'])['extension'];
        $photoName = "{$_SESSION['userID']}.{$file_ext}";

        echo $photoName;
    }
    else {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Nieprawne zdjęcie.")));
        die;
    }

    // $experie

    function validateExperienceOrEducation($rawString) {
        
    }

    function isPhoto($photoFileName) {
        return @is_array(getimagesize($photoFileName));
    }

    function validatePhoneNumber($phoneNumber) {   
        require_once("../vendor/autoload.php");
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        return $phoneNumberUtil->isPossibleNumber($phoneNumber);
    }

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
?>