<?php
    // print_r($_POST);

    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (empty($_POST['firstNameLastName']) || empty($_POST['dateOfBirth']) || empty($_POST['email']) || empty($_POST['nationality'])) {
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

    require('database-functions.php');
    $connect = database_connect_to_mysql();
    if(!$connect) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }
    
    $firstAndLastName = explode(' ', $_POST['firstNameLastName']);
    if (count($firstAndLastName) < 2) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Musisz podać poprawne pierwsze imię i nazwisko.")));
        die;
    }
    $firstName = $connect->real_escape_string(htmlentities($firstAndLastName[0]));
    unset($firstAndLastName[0]);
    $firstAndLastName = array_values($firstAndLastName);
    $lastName = $connect->real_escape_string(htmlentities(implode(" ", $firstAndLastName)));
    $firstName = "'$firstName'";
    $lastName = "'$lastName'";

    $dateOfBirth = $_POST['dateOfBirth'];
    if (!validateDate($dateOfBirth)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawna data urodzenia.")));
        die;
    } // check if data is valid
    $dateOfBirth = "'$dateOfBirth'";

    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędny e-mail.")));
        die;
    } // check if email is email
    $email = "'$email'";

    $nationality = $_POST['nationality'];

    $codes = require('world.php');
    $isNationalityValid = array_search($nationality, array_column($codes, 'alpha2')); // check if nationality is valid

    if(!$isNationalityValid) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Błędna narodowość.")));
        die;
    } 
    $nationality = "'$nationality'";

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
    } // check if phone number is valid

    $photoNameDatabase = "";
    $photoName = "";
    $photoOldName = "";
    $tempName = "";
    $result = $connect->query("SELECT photo_name FROM user_employees WHERE id = (SELECT accounts.id_user_data FROM accounts WHERE accounts.id = {$_SESSION['userID']})");
    if (!$result) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }
    //$photoOldName = $result->fetch_assoc()['photo_name']; Nie działa. Trzeba naprawić kiedyś.
    // echo $photoOldName;
    
    if (empty($_FILES['photo']['tmp_name'])) {
        if ($_POST['photo_changed'] === "true") {
            $photoNameDatabase = "NULL";
        }
        else {
            $photoNameDatabase = "'$photoOldName'";
        }
    }
    else if (isPhoto($_FILES['photo']['tmp_name'])) {
        $tempName = $_FILES['photo']['tmp_name'];

        $file_ext = pathinfo($_FILES['photo']['name'])['extension'];
        $photoName = "{$_SESSION['userID']}.{$file_ext}";

        // echo $photoName;
        $photoNameDatabase = "'$photoName'";
    }
    else {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Nieprawne zdjęcie.")));
        die;
    } // check if photo is valid

    $experience = 'NULL';
    if (!empty($_POST['experience'])) {
        if (!validateExperienceOrEducation($_POST['experience'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $experience = convertExperienceOrEducationToString($connect, $_POST['experience']);
        if ($experience == "") $experience = 'NULL';
        else $experience = "'$experience'";
    } // check if experience is valid

    $education = 'NULL';
    if (!empty($_POST['education'])) {
        if (!validateExperienceOrEducation($_POST['education'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $education = convertExperienceOrEducationToString($connect, $_POST['education']);
        if ($education == "") $education = 'NULL';
        else $education = "'$education'";
    } // check if education is valid
    
    $language = 'NULL';
    if (!empty($_POST['language'])) {
        if (!validateLanguage($_POST['language'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $language = convertLanguage($connect, $_POST['language']);
        if ($language == "") $language = 'NULL';
        else $language = "'$language'";
    } // check if language is valid
    
    $abilities = 'NULL';
    if (!empty($_POST['skill'])) {
        if (!validateArray($_POST['skill'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $abilities = convertArray($connect, $_POST['skill']);
        if ($abilities == "") $abilities = 'NULL';
        else $abilities = "'$abilities'";
    } // check if abilities is valid

    $interests = 'NULL';
    if (!empty($_POST['interests'])) {
        if (!validateArray($_POST['interests'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $interests = convertArray($connect, $_POST['interests']);
        if ($interests == "") $interests = 'NULL';
        else $interests = "'$interests'";
    } // check if interests is valid

    $description = 'NULL';
    if (!empty($_POST['description'])) {
        if (strlen($_POST['description']) > 500) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $description = $connect->real_escape_string(htmlentities($_POST['description']));
        if ($description == "") $description = 'NULL';
        else $description = "'$description'";
    } // check if description is valid

    // echo $firstName . " " . $lastName . " " . $dateOfBirth . " " . $email . " " . $nationality . " " . $phoneNumber . " " . $photoName . " " . $experience . " " . $education . " " . $language . " " . $abilities . " " . $interests . " " . $description;

    $result = $connect->query("START TRANSACTION");
    if (!$result) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }
    $result = $connect->query("UPDATE user_employees SET first_name = $firstName, last_name = $lastName, photo_name = $photoNameDatabase, about_me = $description, nationality = $nationality, birth_date = $dateOfBirth, contact_email = $email, phone_number= $phoneNumber, experience= $experience, education = $education, abilities = $abilities, language_abilities = $language, interests = $interests WHERE id = (SELECT accounts.id_user_data FROM accounts WHERE id = {$_SESSION['userID']})");
    if (!$result) {
        // $connect->query("ROLLBACK");
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }
    
    if ($_POST['photo_changed'] === "true") {
        if(move_uploaded_file($tempName, "../assets/images/cv-photo/$photoName")) {
            if ($photoName != $photoOldName) {
                if (true) {
                    $connect->query("COMMIT");
                }
                else {
                    $connect->query("ROLLBACK");
                    echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
                    die;
                }
            }
        }
        else {
            $connect->query("ROLLBACK");
            // echo "jol";
            echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
            die;
        }
    }

    $connect->query("COMMIT");
    $connect->close();
    echo json_encode(array('success' => true));
    die;

    function convertArray($connect, $arrayWithData) {
        $data = array_values($arrayWithData);

        $linesArray = array();
        for ($i=0; $i < count($data); $i++) {
            $dataValid = $connect->real_escape_string(htmlentities($data[$i]));
            if ($dataValid != "") {
                $linesArray[$i] = $dataValid;
            }
        }
        return implode(";", $linesArray);
    }

    function validateArray($arrayWithData) {
        foreach ($arrayWithData as $data) {
            if(strlen($data) > 50) {
                return false;
            }
        }
        return true;
    }

    function convertLanguage($connect, $arrayWithData) {
        $name = array_values($arrayWithData['name']);
        $level = array_values($arrayWithData['level']);

        $linesArray = array();
        for ($i=0; $i < count($name); $i++) {
            $nameValid = $connect->real_escape_string(htmlentities($name[$i]));
            if ($nameValid != "") {
                $linesArray[$i] = $nameValid . "\\\\";
                if (isset($level[$i])) {
                    $levelValid = $connect->real_escape_string(htmlentities($level[$i]));
                    $linesArray[$i] .= $levelValid;
                }
            }
        }
        return implode(";", $linesArray);
    }

    function validateLanguage($arrayWithData) {
        if (count($arrayWithData['name']) < count($arrayWithData['level'])) {
            return false;
        }
        foreach ($arrayWithData["name"] as $data) {
            if(strlen($data) > 50) {
                return false;
            }
        }
        foreach ($arrayWithData['level'] as $level) {
            if(strlen($level) > 20) {
                return false;
            }
        }
        return true;
    }

    function convertExperienceOrEducationToString($connect, $arrayWithData) {
        $name = array_values($arrayWithData['name']);
        $dateFrom = array_values($arrayWithData['dateFrom']);
        $dateTo = array_values($arrayWithData['dateTo']);

        $linesArray = array();
        for ($i=0; $i < count($name); $i++) {
            if ($name[$i] != "") {
                $nameValid = $connect->real_escape_string(htmlentities($name[$i]));
                $linesArray[$i] = $nameValid . "\\\\";
                if (isset($dateFrom[$i])) {
                    $dateFromValid = $connect->real_escape_string(htmlentities($dateFrom[$i]));
                    $linesArray[$i] .= $dateFromValid;
                }
                $linesArray[$i] .= "\\\\";
                if (isset($dateTo[$i])) {
                    if ($dateTo[$i] === "on") {
                        $linesArray[$i] .= "now";
                    }
                    else {
                        $dateToValid = $connect->real_escape_string(htmlentities($dateTo[$i]));
                        $linesArray[$i] .= $dateToValid;
                    }
                } 
            }
        }
        return implode(";", $linesArray);
    }

    function validateExperienceOrEducation($arrayWithData) {
        if (count($arrayWithData['name']) < count($arrayWithData['dateFrom']) || count($arrayWithData['name']) < count($arrayWithData['dateTo'])) {
            return false;
        }
        foreach ($arrayWithData['name'] as $data) {
            if (strlen($data) > 100) {
                return false;
            }
        }
        foreach ($arrayWithData["dateFrom"] as $data) {
            if (!validateDate($data) && $data != "") {
                return false;
            }
        }
        foreach ($arrayWithData['dateTo'] as $data) {
            if (!validateDate($data) && $data != "on" && $data != "") {
                return false;
            }
        }
        return true;
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