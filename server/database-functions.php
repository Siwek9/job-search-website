<?php
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// returns 'mysqli_connection' if success or 'false' if failure
function database_connect_to_mysql() {
    $connect = "";
    try {
        $connect = new mysqli("localhost", "root", "", "job_search_website");
    }
    catch(Exception $e) {
        return false;
    }

    if ($connect->connect_errno) {
        return false;
    }

    return $connect;
}

// returns bool on success or throws exception if failure
function database_name_exists($connect, $name) {
    $result = $connect->query("SELECT name FROM accounts WHERE name LIKE '$name'");

    if (!$result) throw new Exception("Cannot run query");
    return boolval($result->num_rows);
}

// returns bool on success or throws exception if failure
function database_email_exists($connect, $email) {
    $result = $connect->query("SELECT email FROM accounts WHERE name LIKE '$email'");

    if (!$result) throw new Exception("Cannot run query");
    return boolval($result->num_rows);
}

// returns result array when transaction was successfull or false if transaction failure
function database_transaction($connect, $queries) {
    $connect->query("START TRANSACTION");
    $resultArray = array();
    $isError = false;

    for ($i = 0; $i < count ($queries); $i++){
        try {
            if (!($resultArray[$i] = $connect->query($queries[$i]))){
                $isError = true;
                echo $connect->error;
                break;
            }   
        }
        catch(Exception $e) {
            echo $connect->error;
            $isError = true;
            break;
        }
    }

    if (!$isError){
        $connect->query("COMMIT");
        return $resultArray;
    }
    else {
        $connect->query("ROLLBACK");
        return false;
    }


}

?>