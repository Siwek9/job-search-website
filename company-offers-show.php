<?php
    session_start();

    if (empty($_SESSION['isLogged']) || empty($_SESSION['accountType'])) {
        header("Location:index.php");
        die;
    }
    
    if ($_SESSION['accountType'] != 'employee') {
        header("Location:index.php");
        die;
    }

    require_once('server/database-functions.php');

    $connect = database_connect_to_mysql();

    $result = $connect->query("SELECT * FROM user_employers WHERE user_employers.id = (SELECT accounts.id_user_data FROM accounts WHERE accounts.id = {$_SESSION['userID']});");

    $userData = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/styles/start_page.css">
    <title>Nazwa firmy</title> <!-- TODO: Zrób żeby tu się wyświetlała nazwa firmy -->
</head>
<body>
    <div id="myData" style="height: auto;">
        <h1>Dane Firmy</h1>
        <div id="loginPass">
            <b>Login: </b> login <br>
            <b>Adres E-Mail: </b> aaa@aaa.com <br>
        </div>
    </div>
    <div id="jobOffers">
        <h1>Oferty pracy</h1> <!-- TODO: Zrób żeby tu się wyświetlała nazwa firmy -->

        <div id="wrapper">
            <!-- Dosłownie ma się wyświetlać tak samo jak oferty na stronie firmy. Dodaj tylko na dole przycisk aplikuj (button#save) nazwa id niezgodna ale działa XD. Jeśli zgłoszenie zostało wysłane po prostu przeładuj stronę i zmień button na zwykły <div style="font: 600 30px Poppins">Zgłoszenie zostało wysłane</div> -->
            <?php 
                $result = $connect->query("SELECT * FROM job_offers WHERE company_id = {$_GET['companyID']}");
                if ($result) {
                    require('server/show.php');
                    while($row = $result->fetch_assoc()) {
                        echo offerShow($row, $userData['company_logo']);
                    }
                }
            ?>
        </div>
    
</body>
</html>