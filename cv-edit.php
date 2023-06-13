<?php
    session_start();

    if (empty($_SESSION['isLogged']) || empty($_SESSION['accountType'])) {
        header("Location:index.php");
        die;
    }
    
    if ($_SESSION['accountType'] != 'employee' && $_SESSION['accountType'] != 'employer') {
        header("Location:index.php");
        die;
    }

    require_once('server/database-functions.php');

    $connect = database_connect_to_mysql();
    if (!$connect) {
        header("Location:index.php");
        die;
    }
    $result = $connect->query("SELECT * FROM user_employees WHERE user_employees.id = (SELECT accounts.id_user_data FROM accounts WHERE accounts.id = {$_SESSION['userID']});");
    if (!$result) {
        header("Location:index.php");
        die;
    }
    $userData = $result->fetch_assoc();
    if (is_null($userData['first_name'])) {
        $userData['first_name'] = "";
    }
    if (is_null($userData['last_name'])) {
        $userData['last_name'] = "";
    }
    if (is_null($userData['photo_name'])) {
        $userData['photo_name'] = "";
    }
    if (is_null($userData['about_me'])) {
        $userData['about_me'] = "";
    }
    if (is_null($userData['contact_email'])) {
        $userData['contact_email'] = "";
    }
    if (is_null($userData['phone_number'])) {
        $userData['phone_number'] = "";
    }
    if (is_null($userData['expierience'])) {
        $userData['expierience'] = "";
    }
    if (is_null($userData['education'])) {
        $userData['education'] = "";
    }
    if (is_null($userData['abilities'])) {
        $userData['abilities'] = "";
    }
    if (is_null($userData['language_abilities'])) {
        $userData['language_abilities'] = "";
    }
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
    <script src="cv-edit.js" defer></script>
    <title>Edytuj swoje CV</title>
</head>
<body>
    <nav>
        <div id="logo">JobSE <span>Job finding made easy</span></div>
    </nav>
    
    <div class="flex">
    <div id="myData">
        <h2>Moje CV</h2>
        <form class="cv">
            <div class="cv-photo">
                <img class="image" src="assets/images/company-logo/FajnaFirma-6.png" alt="" draggable="false">
            </div>
            <div class="cv-name">
                    <input type="text" placeholder="Imię i nazwisko*" name="firstname_lastname" value="<?php echo $userData['first_name'] . " " . $userData['last_name']; ?>" id=""> 
            </div>
            <div class="cv-info relative">
                <span class="title relative">
                    Informacje
                    <div style="content: ''; position: absolute;left: 11.3rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 11.3rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                
                <b>Data urodzenia: </b> <input type="date" name="dataOfBirth" id=""> <br>
                <b>E-mail:</b> <input placeholder="E-Mail" type="email" name="email" id=""> <br>
                <b>Number telefonu:</b> <input placeholder="Numer telefonu" type="tel" name="tel" id=""> <br> <br>
                <b>Zdjęcie</b> <input type="file" name="file" id="file"> <label for="file" id="fileLbl">Dodaj zdjęcie</label>
            </div>
            <div class="cv-job-experience-education relative">
                <span class="title">
                    Edukacja i Doświadczenie
                    <div style="content: ''; position: absolute;left: 24.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 24.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <b>Doświadczenie Zawodowe:</b> <button id="addExperience">Dodaj doświadczenie</button>
                <ul id="experienceList">
                </ul>
                <b>Edukacja:</b> <button id="addEducation">Dodaj edukacje</button>
                <ul id="educationList">
                </ul>
            </div>
            <div class="cv-abilities-interests relative">
                <span class="title">
                    Umiejętności i Zainteresowania
                    <div style="content: ''; position: absolute;left: 29.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 29.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <b>Znajomość języków:</b> <button id="addLanguage">Dodaj język</button>
                <ul id="languageList">
                </ul>
                <b>Umiejętności:</b> <button id="addSkill">Dodaj umiejętność</button>
                <ul id="skillList">
                </ul>
                <b>Zainteresowania:</b> <button id="addInterest">Dodaj zainteresowanie</button>
                <ul id="interestList">
                </ul>
            </div>
            <div class="cv-description relative">
                <span class="title">
                    O mnie
                    <div style="content: ''; position: absolute;left: 7.96rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 7.96rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <textarea name="desc" id="" cols="30" rows="10"></textarea>
            </div>
            <button id="save">Zapisz CV</button>
        </form>
        <br>
        <br>    
    </div>
</div>
</body>
</html>