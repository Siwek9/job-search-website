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
    if (!$connect) {
        header("Location:index.php");
        die;
    }
    $result = $connect->query("SELECT company_logo FROM user_employers WHERE user_employers.id = (SELECT accounts.id_user_data FROM accounts WHERE accounts.id = {$_SESSION['userID']});");
    if (!$result) {
        header("Location:index.php");
        die;
    }
    $companyLogo = $result->fetch_assoc()['company_logo'];

    $offerData = "";
    if (!empty($_GET['offerID']) && is_numeric($_GET['offerID'])) {
        $result = $connect->query("SELECT * FROM job_offers WHERE id = {$_GET['offerID']}");
        if (!$result) {
            header("Location:index.php");
            die;
        }
        $offerData = $result->fetch_assoc();
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
  		src="https://code.jquery.com/jquery-3.6.4.js"
  		integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  		crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="offer-edit.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/styles/start_page.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <title>Edytuj swoją Ofertę</title>
</head>
<body>
    <nav>
        <div id="logo">JobSE <span>Job finding made easy</span></div>
    </nav>
    
    <div class="flex">
        <div id="jobOffers">
        <h1>Moja oferta pracy</h1>
        <form id="offer-form" class="cv" style="width: 50rem;">
            <div class="job-photo">
            <?php
                if (!is_null($companyLogo)) {
                    echo "<img class='image' src='assets/images/company-logo/{$companyLogo}' alt='' draggable='false'>";
                }
            ?>
            </div>
            <div class="cv-name" >
                <input type="text" maxlength="100" name="jobName" placeholder="Nazwa stanowiska*" value="<?php 
                    if (isset($offerData['job_position'])) {
                        echo $offerData['job_position'];
                    }
                ?>">
            </div>
            <div class="job-info relative">
                <span class="title relative">
                    Informacje
                    <div style="content: ''; position: absolute;left: 11.3rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 11.3rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <!-- DATA: workplace -->
                <b>Miejsce pracy*: </b><input type="text" name="workplace" value="<?php 
                    if (!empty($offerData['job_place'])) {
                        echo $offerData['job_place'];
                    }
                    ?>" id=""><br>
                    <!-- DATA: contractPeriod -->
                    <b>Okres umowy*: </b><input type="number" name="contractPeriod" value="<?php 
                    if (!empty($offerData['job_years'])) {
                        echo $offerData['job_years'];
                    }
                    ?>" id=""> lata<br>
                    <!-- DATA: contactPhone -->
                <b>Telefon kontaktowy*: </b><input style="margin-bottom: 1.6rem" type="text" name="contactPhone" id="phone"><br>
                <script>
                    var phoneInput = document.querySelector("#phone");
                    window.intlTelInput(phoneInput, {
                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                        preferredCountries: ["pl", "gb", "us", "ua", "de"]
                    });
                    var iti = intlTelInput(phoneInput);
                    iti.setNumber("<?php if (isset($offerData['job_contact_phone'])) { echo $offerData['job_contact_phone']; } ?>");
                </script>
            </div>
            <div class="job-requirements relative">
                <span class="title">
                    Wymagania
                    <div style="content: ''; position: absolute;left: 12.7rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 12.7rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <b>Umiejętności:</b> <button id="addSkill">Dodaj umiejętność</button>
                <ul id="skillList">
                <?php
                    if (!empty($offerData['job_abilities']) && $offerData['job_abilities'] != "") {
                        $skillList = explode(";", $offerData['job_abilities']);
                        $j = 0;
                        foreach ($skillList as $skill) {
                            echo "<li id='skill{$j}'><input placeholder='Umiejętność' value='$skill' maxlength='50' type='text' name='skill[{$j}]'><i class='fa-solid fa-trash fa-xl delSkill' id='delSkill{$j}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            $j++;
                        }
                    }
                ?>
                </ul>
                <br>
                <b>Edukacja:</b><button id="addEducation">Dodaj edukacje</button>
                <ul id="educationList"> 
                <?php
                    if (!empty($offerData['job_education']) && $offerData['job_education'] != "") {
                        $educationList = explode(";", $offerData['job_education']);
                        $j = 0;
                        foreach ($educationList as $education) {
                            echo "<li id='edu{$j}'><input placeholder='Edukacja' value='$education' maxlength='100' type='text' name='education[{$j}]'><i class='fa-solid fa-trash fa-xl delEdu' id='delEdu{$j}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            $j++;
                        }
                    }
                ?>
                </ul>
            </div>
            <div class="job-desc relative">
                <span class="title">
                    Opis
                    <div style="content: ''; position: absolute;left: 5.6rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 5.6rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <textarea style="resize: none" name="desc" id="" cols="30" rows="10"><?php if (!empty($offerData['job_description'])) { echo $offerData['job_description']; } ?></textarea> 
            </div>
            <input type="submit" id="save" value="Zapisz ofertę">
            <div id="errorBack">
                <div id="error-message">
                    <div id="error">Błąd po stronie serwera </div>
                    <button type="button" id="tryAgain">Spróbuj ponownie</button>
                </div>
            </div>
            <div style="margin-top: 1rem;">* - informacje obowiązkowe</div>
        </form>
    </div>
    </div>
</body>
</html>