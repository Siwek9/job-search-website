<?php
    session_start();

    if (empty($_SESSION['isLogged']) || empty($_SESSION['accountType'])) {
        header("Location:index.php");
        die;
    }
    
    if ($_SESSION['accountType'] != 'employer') {
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
    <title>Moja Firma</title>
</head>
<body>
    <div style="<?php 
        if (is_null($userData['first_name'])) {
            echo "display: block";
        }
        else {
            echo "display: none";
        }
    ?>" >Skompletuj swoje CV, żeby móc wysyłać swoje zgłoszenia o pracę! <a href="cv-edit.php">Napisz CV</a></div>
    <nav>
        <div id="logo">JobSE <span>Job finding made easy</span></div>
        <div id="links">
            <a href="#workApplications">Zgłoszenia o pracę</a>
            <a href="#jobOffers">Moje oferty</a>
            <a href="#myData">Moje Dane</a>
            <a href="server/logout-user.php">Wyloguj się</a>
        </div>
    </nav>
    <div class="flex">
    <div id="workApplications">
        <h1>Zgłoszenia o pracę</h1>
        <div id="flex2">
        <div class="appCard"> <!-- Cały ten div w php wyświetl, z danymi oczywiście -->
            <div class="infoC">
                <div>
                    <img class="image" src="assets/images/company-logo/FajnaFirma-6.png" alt="" draggable="false">
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>

        <div class="appCard">
            <div class="infoC">
                <div>
                    <!-- img -->
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>

        <div class="appCard">
            <div class="infoC">
                <div>
                    <!-- img -->
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>

        <div class="appCard">
            <div class="infoC">
                <div>
                    <!-- img -->
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>

        <div class="appCard">
            <div class="infoC">
                <div>
                    <!-- img -->
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>

        <div class="appCard">
            <div class="infoC">
                <div>
                    <!-- img -->
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Imię Nazwisko</h2>
                    <div>Doświadczenie: brak</div>
                    <div>Umiejętności: znajomość C++</div>
                </div>
            </div>
            <div class="rightB">
                <button>Zobacz CV</button>
            </div>
        </div>
    </div>
    </div>
    <div id="jobOffers">
        <h1>Moje oferty pracy</h1>
        <a href="offer-edit.php"><button id="addOffer">Dodaj ofertę pracy</button></a>

        <div id="wrapper">
            <?php
                $result = $connect->query("SELECT * FROM job_offers WHERE company_id = {$_SESSION['userID']}");
                if ($result) {
                    require('server/show.php');
                    while($row = $result->fetch_assoc()) {
                        echo offerShow($row, $userData['company_logo']);
                    }
                }
            ?>
        </div>
    <div id="myData" style="height: auto;">
        <h1>Dane mojej firmy</h1>
        <div id="loginPass">
            <div id="firmData">
                <img src="assets/images/company-logo/56.png" alt="">
                <b>Właściciel: </b> <span>Gienek Bocian</span>
                <b>Nazwa firmy: </b> <span>Bocian i Spółka</span>
                <b>Adres E-Mail: </b> <span>bocian@aa.com</span>
                <b>Adres: </b> <span>Zadupie ul.Gdzieś w lesie</span>
                <b>Opis: </b> <span>Specjalizujemy się w: tak naprawdę to nie wiadomo co robimy</span> 
                <div style="display:flex; flex-direction: row-reverse">
                    <a href='edit-data.php' id='edit' style="width: 8rem; margin-right: 1rem">Edytuj dane</a>
                </div>
            </div>
        </div>
        <h1>Dane mojego konta</h1>
        <div id="loginPass">
            <b>Login: </b> login <br>
            <b>Adres E-Mail: </b> aaa@aaa.com <br>
        </div>
        
    </div>
</div>
</body>
</html>