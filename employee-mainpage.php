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
    <?php
        
    ?>
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
            <div class="relative">
                <img class="image" src="assets/images/company-logo/Januszex-1.png" alt="" draggable="false">
                <div class="info">
                    Januszex<br>Firma IT<br>230 stanowisk <br>
                </div>
            </div>
            <!-- Zrób tak ze ten div jest dla kazdego obrazka i ze sie wyswietla ładnie nad nim  -->
            <div class="relative">
                <img class="image" src="assets/images/company-logo/PolandShop-2.png" alt="" draggable="false">
                <div class="info">
                    PolandShop<br>Sklep Spożywczy<br>170 stanowisk
                </div>
            </div>
            <div class="relative">
                <img class="image" src="assets/images/company-logo/Pieronka-3.png" alt="" draggable="false">
                <div class="info">
                    Pieronka<br>Sklep Spożywczy<br>170 stanowisk
                </div>
            </div>
            <div class="relative">
                <img class="image" src="assets/images/company-logo/Tani_Market-4.png" alt="" draggable="false">
                <div class="info">
                    Tani Market<br>Sklep spożywczy<br>20 stanowisk
                </div>
            </div>
            <div class="relative">
                <img class="image" src="assets/images/company-logo/Dobry_Sklep-5.png" alt="" draggable="false">
                <div class="info">
                    Dobry Sklep<br>Sklep z odzieżą<br>200 stanowisk
                </div>
            </div>
            <div class="relative">
                <img class="image" src="assets/images/company-logo/FajnaFirma-6.png" alt="" draggable="false">
                <div class="info">
                    Gamrat<br>Przetwórstwo tworzyw sztucznych<br>1 stanowisko
                </div>
            </div>
            <div class="relative">
                <img class="image" src="assets/images/company-logo/DobryWęgiel-7.png" alt="" draggable="false">
                <div class="info">
                    Dobry Węgiel<br>Skup zwierząt<br>110 stanowisk
            </div>
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
        <a href='cv-edit.php' id='edit'>Edytuj dane</a>
        <br>
        <br>    
    </div>
</div>
</body>
</html>