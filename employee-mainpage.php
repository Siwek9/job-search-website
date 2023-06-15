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

    $result = $connect->query("SELECT * FROM user_employees WHERE user_employees.id = (SELECT accounts.id_user_data FROM accounts WHERE accounts.id = {$_SESSION['userID']});");

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
    <script src="employee-mainpage.js" defer></script>
    <title>Document</title>
</head>
<body>
    <!-- TODO: pop-up ze jak sie nie zrobiło cv to sie odpala i cie prosi o zrobienie -->
    <div style="<?php 
        if (is_null($userData['first_name'])) {
            echo "display: block";
        }
        else {
            echo "display: none";
        }
    ?>" >Skompletuj swoje CV, żeby móc wysyłać swoje zgłoszenia o pracę! <a href="cv-edit.php">Napisz CV</a></div>
    <nav>
        <div id="logo">JobSE <span>Job finding made easy</span></div> <!-- Tu trzeba nazwę wymyślić. Mój pomysł JobSE (Job search) prosto i przyjemnie -->
        <div id="links">
            <a href="#businesses">Proponowane Firmy</a>
            <a href="#myOffers">Zapytania o Pracę</a>
            <a href="#myData">Moje Dane</a>
            <a href="server/logout-user.php">Wyloguj się</a>
        </div>
    </nav>
    
    <div id="businesses">
        <div id="imageTrack" data-mouse-down-at="0" data-prev-percentage="0">
            <?php
                $result = $connect->query("SELECT user_employers.id, user_employers.company_name, user_employers.company_address, user_employers.company_logo, job_offers_number.offers_number FROM user_employers JOIN (SELECT job_offers_number.company_id, COUNT(*) AS offers_number FROM job_offers AS job_offers_number GROUP BY job_offers_number.company_id) AS job_offers_number ON job_offers_number.company_id = (SELECT accounts.id FROM accounts WHERE accounts.id_user_data = user_employers.id)");
                if ($result) {
                    while($row = $result->fetch_assoc()) {
                        echo "<a href='company-offers-show.php?companyID={$row['id']}' class='relative slider'>";
                        if (!is_null($row['company_logo'])) {
                            echo "<img id='{$row['id']}' class='image' src='assets/images/company-logo/{$row['company_logo']}' alt='' draggable='false'>";
                        }
                        else {
                            echo "<img id='{$row['id']}' class='image' alt='' draggable='false'>";
                        }
                        echo "<div class='info'>";
                        if (!is_null($row['company_name'])){
                            echo $row['company_name'] . "<br>";
                        }
                        else {
                            echo "Nieznane" . "<br>";
                        }
                        if (!is_null($row['company_address'])){
                            echo $row['company_address'] . "<br>";
                        }
                        else {
                            echo "Nieznane" . "<br>";
                        }
                        if (!is_null($row['offers_number'])){
                            echo $row['offers_number'] . "stanowisk<br>";
                        }
                        else {
                            echo "0 stanowisk" . "<br>";
                        }
                        echo "</div>
                        </a></>";
                    }
                }

            ?>
        </div>
        </div>
    </div>
    <div class="flex">
    <div id="myOffers">
        <h1>Moje oferty pracy</h1>
        tu będą sie wyswietlać wszytkie firmy do których wysłaliśmy wiadomość o zainteresowaniu i czy nam odpowiedziały czy nie
    </div>
    <div id="myData">
        <h1>Moje dane</h1>
        <div id="loginPass">
            <b>Login: </b> login <br>
            <b>Adres E-Mail: </b> aaa@aaa.com <br>
        </div>
        <h2>Moje CV</h2>
        <?php 
            require("server/show.php");
            if (!is_null($userData['first_name'])) {
                echo cvShow($userData);
            }
        ?>
        <div style="display:flex; justify-content: center;"><a href='cv-edit.php' id='edit'>Edytuj dane</a></div>
        <br>
        <br>    
    </div>
</div>
</body>
</html>