<?php
// returns 'mysqli_connection' if success or 'false' if failure
function connect_to_mysql() {
    $connect = "";
    try {
        $connect = new mysqli("localhost", "root", "", "user-profiles");
    }
    catch(Exception $e) {
        return false;
    }

    if ($connect->connect_errno) {
        return false;
    }

    return $connect;
}

?>