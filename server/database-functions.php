<?php
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

function database_name_exists($connect, $name) {
    $stmt = $connect->prepare("SELECT name FROM accounts WHERE name LIKE ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();

    return boolval($stmt->num_rows());
}

function database_email_exists($connect, $email) {
    $stmt = $connect->prepare("SELECT email FROM accounts WHERE email LIKE ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    return boolval($stmt->num_rows());
}

?>