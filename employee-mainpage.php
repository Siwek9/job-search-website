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
            require("server/cv-show.php");
            if (!is_null($userData['first_name'])) {
                echo cvShow($userData);
            }
        ?>
        <!-- <div class="cv">
            <div class="cv-photo">
                <img class="image" src="assets/images/company-logo/FajnaFirma-6.png" alt="" draggable="false">
            </div>
            <div class="cv-name">
                    
            </div>
            <div class="cv-info relative">
                <span class="title relative">
                    Informacje
                    <div style="content: ''; position: absolute;left: 11.3rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 11.3rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                
                <b>Data urodzenia: </b>10.05.1787 <br>
                <b>E-mail:</b> aaa@aaa.com <br>
                <b>Number telefonu:</b> 123456789
            </div>
            <div class="cv-job-experience-education relative">
                <span class="title">
                    Edukacja i Doświadczenie
                    <div style="content: ''; position: absolute;left: 24.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 24.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <b>Doświadczenie Zawodowe:</b>
                <ul>
                    <li>Specjalista Ds. Marketingu w PolandShop (2006-10 do 2012-12)</li>
                    <li>Specjalista Ds. Marketingu w PolandShop (2006-10 <b>do</b> 2012-12)</li>
                </ul>
                <b>Edukacja:</b>
                <ul>
                    <li>Elektryk Krosno (kierunek ping-pong) (2002-09 <b>do</b> 2005-06)</li>
                </ul>
            </div>
            <div class="cv-abilities-interests relative">
                <span class="title">
                    Umiejętności i Zainteresowania
                    <div style="content: ''; position: absolute;left: 29.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 29.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <b>Znajomość języków:</b>
                <ul>
                    <li>Język Angielski (Poziom C1)</li>
                </ul>
                <b>Umiejętności:</b>
                <ul>
                    <li>granie w ping ponga</li>
                    <li>Znajomość języka assembler, MOO language</li>
                </ul>
                <b>Zainteresowania:</b>
                <ul>
                    <li>Granie na nerwach</li>
                    <li>C++</li>
                    <li>Żaba</li>
                </ul>
            </div>
            <div class="cv-description relative">
                <span class="title">
                    O mnie
                    <div style="content: ''; position: absolute;left: 7.96rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 7.96rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                Nazywam się Kononowicz Krzysztof. Urodziłem się dnia dwudziestego pierwszego stycznia tysiąc dziewięćset trzeciego… sześciesiątego trzeciego roku w Kętrzynie, woe… woewództwo olsztynskie. Chcę przedstawić swój życiorys. Ukończyłem zasadniczą szkołę zawodową jako kierowca-mechanik. Posiadam swoją posiadłość – domek drewniany. Mam matkę, mam brata. Tatuś ni żyje. Ale tatuś bardzo jest mój bardzo, bardzo zasłużony. Walczył o Warszawę, walczył o Polskę, walczył o Boga. Ale nie ma ojca – odeszedł. Jak ja mówię – powołał, zmienił miejsce zamieszkania. Jest w niebie teraz. I stamtąd patrzy, jak ja kandyduje na prezydenta miasta Białegostoku. Chcę zrobić dla naszego miasta Białegostoku następujące rzeczy. Zlikwidować całkowicie dla młodzieży alkohol, papierosy i narkotyki. Usprawnić w naszym Białymstoku komunikację miejską; miejską i dalekobieżną. Tak! Bo nasza komunikacja jest bardzo, bardzo słaba, bardzo zła. Otworzyć zakłady i miejsca pracy dla młodzieży i dla ludzi. Tak! I chcę bardzo, bardzo to zrobić. Usprawnić w naszym mieście, w całym, na całym Podlasiu, żeby nie było bandyctwa, żeby nie było złodziejstwa, żeby nie było niczego. Żeby starsi ludzie mogli przejść, bo nawet teraz dochodzi do mnie – skargi, postulaty, apelują starsze ludzie, w podeszłym wieku, że młodzież zaczepia. A ja się nie dziwię się, że młodzież starszych ludzi zaczepia, napada, napadają i tak dalej. Bo młodzież nie ma pracy, nie ma pracy! Zakłady nasze w Białymstoku są rozwalane, zanim zbudowane. Zamiast usprawnić Białystok, żeby miejsca pracy, tak jak Fasty są rozwalone, tak jak mleczarnie tu w Białymstoku, tak jak Spomasz w Starosielcach. Tak jak…. i inne zakłady są rozwalane. I chcę też wyprowadzić policje na ulice. Chcę wyprowadzić policje, żeby policja pilnowała całego naszego porządku, bo od tego jest policja i straż miejska. Od tego oni są! Od tego są oni! Od tego są. A w urzędzie u mie miejskim będzie ład i porządek. Ni będzie biurokractwa, ni będzie łachmactwa, tylko naprawdę ludzie będą. Zimową porą będą szykować architekci plany budowy dróg, plany budowy dróg. Podkreślam jeszcze raz: plany budowy dróg. A na wiosnę wyjdziemy z budową ulic i… ulic, bo jakie mamy drogi? Jakie mamy? Co się stao się pod Jeżewem? Co się stao się? A kierowcy też będą przez policję surowo karani, za alkohol, za papierosy, za wszystko. I jeszcze też usprawnię granice w Kuźnicy i Bobrownikach, że granica między Białorusią a nami będzie naprawdę, naprawdę będzie granica, że ni będzie przemytu, ani papierosów, ani narkotyków, ani alkoholu. Szanowne Państwo! Kandyduję z ramienia… Polasia XXI wieku. Bardzo proszę o oddanie na mnie głos. To co przedstawiłem, swoje postulaty, to ja wszystko uczynię i na mnie warto głosować, bo ja jestem naprawdę człowiekiem uczciwym i sprawiedliwym. Nie tak, że inne partie, inne komitety, inne partie mówią, a nic ni robią, a nic ni zrobili dla miasta Białegostoku, a to co ja powiedziałem to ja wszystko uczynię, bo jestem człowiekiem wierzącym i praktykującym i wiem na jakiej zasadzie to zrobić, jak uczynić, jak usprawnić drogi, jak wszystko, jak zlikwidować papierosy, jak wszystko zlikwidować. I bardzo proszę całego miasta Białegostoku i całego Podlasia oddać na mnie głos, dziękuję państwu.
            </div>
            <a href="cv-edit.php" id="edit">Edytuj dane</a>
        </div> -->
        <br>
        <br>    
    </div>
</div>
</body>
</html>