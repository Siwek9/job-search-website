<?php
    // print_r($_POST);

    $request_method = $_SERVER['REQUEST_METHOD'];
    // echo $request_method;
    if ($request_method != 'POST') {
        header("Location:index.php");
        die;
    } // reject all bad method

    if (empty($_POST['jobName']) || empty($_POST['workplace']) || empty($_POST['contractPeriod']) || empty($_POST['contactPhone'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'missing_fields', 'message' => "Wymagane pola nie mogą być puste.")));
        die;
    } // required fields must be filled in

    session_start();
    if (empty($_SESSION['userID']) || !is_numeric($_SESSION['userID'])) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'no_permission', 'message' => "Nie możesz zmienić CV.")));
        die;
    }

    require('database-functions.php');
    $connect = database_connect_to_mysql();
    if(!$connect) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
        die;
    }

    $jobName = $connect->real_escape_string(htmlentities($_POST['jobName']));
    if (strlen($jobName) > 100) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
        die;
    }
    $jobName = "'$jobName'";

    $workplace = $connect->real_escape_string(htmlentities($_POST['workplace'])); 
    if (strlen($workplace) > 50) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
        die;
    }
    $workplace = "'$workplace'";

    $contractPeriod = $connect->real_escape_string(htmlentities($_POST['contractPeriod']));
    if (!is_numeric($contractPeriod)) {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
        die;
    }

    $contactPhone = $_POST['contactPhone'];
    if (validatePhoneNumber($contactPhone)) {
        $contactPhone = "'$contactPhone'";
    }
    else {
        echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawny numer telefonu.")));
        die;
    } // check if phone number is valid

    $skill = 'NULL';
    if (!empty($_POST['skill'])) {
        if (!validateArray($_POST['skill'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $skill = convertArray($connect, $_POST['skill']);
        if ($skill == "") $skill = 'NULL';
        else $skill = "'$skill'";
    } // check if skill is valid

    $education = 'NULL';
    if (!empty($_POST['education'])) {
        if (!validateArray($_POST['education'])) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $education = convertArray($connect, $_POST['education']);
        if ($education == "") $education = 'NULL';
        else $education = "'$education'";
    } // check if education is valid

    $desc = 'NULL';
    if (!empty($_POST['desc'])) {
        $desc = $connect->real_escape_string(htmlentities($_POST['desc'])); 
        if (strlen($desc) > 500) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'wrong-data', 'message' => "Niepoprawne dane.")));
            die;
        }
        $desc = "'$desc'";
    }

    if (isset($_POST['offerID']) && is_numeric($_POST['offerID'])) {
        $result = $connect->query("SELECT * FROM job_offers WHERE id = {$_POST['offerID']} AND company_id = {$_SESSION['userID']}");
        if (!$result) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
            die;
        }
        if ($result->num_rows == 0) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'no_permission', 'message' => "Nie możesz zmienić CV.")));
            die;
        }
        $offerID = $_POST['offerID'];
        $result = $connect->query("UPDATE job_offers SET job_position=$jobName, job_place=$workplace, job_years=$contractPeriod, job_contact_phone=$contactPhone, job_abilities=$skill, job_education=$education, job_description=$desc WHERE id = $offerID");
        if (!$result) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
            die;
        }
    }
    else {
        $result = $connect->query("INSERT INTO job_offers(job_position, job_place, job_years, job_contact_phone, job_abilities, job_education, job_description, company_id) VALUES ($jobName, $workplace, $contractPeriod, $contactPhone, $skill, $education, $desc, {$_SESSION['userID']})");
        if (!$result) {
            echo json_encode(array('success' => false, 'error' => array('type' => 'time-out', 'message' => "Connection Timed Out. Sprawdź połączenie internetowe.")));
            die;
        }
    }

    echo json_encode(array('success' => true));

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

    function validatePhoneNumber($phoneNumber) {   
        require_once("../vendor/autoload.php");
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        return $phoneNumberUtil->isPossibleNumber($phoneNumber);
    }
?>