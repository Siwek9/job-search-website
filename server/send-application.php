<?php
    session_start();

    require('database-functions.php');
    $connect = database_connect_to_mysql();

    $result = $connect->query("SELECT * FROM job_application WHERE job_offer_id = {$_GET['offerID']} AND job_candidate_id = {$_SESSION['userID']}");
    if($result->num_rows == 0) {
        $result = $connect->query("INSERT INTO job_application(job_offer_id, job_candidate_id, status) VALUES('{$_GET['offerID']}', {$_SESSION['userID']}, 'sended')");
    }

    header("Location:../employee-mainpage.php")

?>