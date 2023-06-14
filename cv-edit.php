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
    if (is_null($userData['birth_date'])) {
        $userData['birth_date'] = "";
    }
    if (is_null($userData['about_me'])) {
        $userData['about_me'] = "";
    }
    if (is_null($userData['nationality'])) {
        $userData['nationality'] = "pl";
    }
    if (is_null($userData['contact_email'])) {
        $userData['contact_email'] = "";
    }
    if (is_null($userData['phone_number'])) {
        $userData['phone_number'] = "";
    }
    if (is_null($userData['experience'])) {
        $userData['experience'] = "";
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
    if (is_null($userData['interests'])) {
        $userData['interests'] = "";
    }
    // echo $userData['birth_date'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script
  		src="https://code.jquery.com/jquery-3.6.4.js"
  		integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
  		crossorigin="anonymous"></script>
    <script src="server/country-select-js/js/countrySelect.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="server/country-select-js/css/countrySelect.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
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
        <form id="cv-form" class="cv">
            <div class="cv-photo">
            <?php
                if ($userData['photo_name']) {
                    echo "<img class='image' src='assets/images/cv-photo/{$userData['photo_name']}' alt='Zdjęcie na CV' draggable='false'>";
                }
                else {
                    echo "<img draggable='false'>";
                }
            ?>
            </div>
            <div class="cv-name" style="margin: 1.7rem 0 2.2rem 0">
                <!-- DATA: First Name and Last Name -->
                <input type="text" placeholder="Imię i nazwisko*" maxlength="50" name="firstNameLastName" value="<?php echo $userData['first_name'] . " " . $userData['last_name']; ?>" id=""> 
            </div>
            <div class="cv-info relative">
                <span class="title relative">
                    Informacje
                    <div style="content: ''; position: absolute;left: 11.3rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 11.3rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>

                <!-- DATA: Date Birth -->
                <b>Data urodzenia*: </b><input type="date" name="dateOfBirth" value="<?php echo $userData['birth_date']; ?>" id=""><br>
                <!-- DATA: E-mail -->
                <b>E-mail*: </b><input style="margin-bottom: 1.6rem" placeholder="E-Mail" type="email" maxlength="50" name="email" value="<?php echo $userData['contact_email']; ?>" id=""><br> 
                <!-- DATA: Nationality -->
                <b>Narodowość*: </b><input type="text" name="nationality" id="country"><br><br>
                <script>
                    $("#country").countrySelect({
                        defaultCountry: "<?php echo $userData['nationality'] ?>",
                        preferredCountries: ["pl", "gb", "us", "ua", "de"]
                    });
                </script>
                <!-- DATA: Phone Number -->
                <b>Number telefonu:</b> <input name="phoneNumber" id="phone"> <br> <br>
                <script>
                    var phoneInput = document.querySelector("#phone");
                    window.intlTelInput(phoneInput, {
                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                        preferredCountries: ["pl", "gb", "us", "ua", "de"]
                    });
                    var iti = intlTelInput(phoneInput);
                    iti.setNumber("<?php echo $userData['phone_number'] ?>");
                </script>
                <!-- DATA: Photo -->
                <?php
                    if($userData['photo_name'] != "") echo "<b>Zdjęcie</b> <input type='file' name='photo' id='file' accept='.png,.jpg,.jpeg'> <label for='file' id='fileLbl'>Aktualne zdjęcie: {$userData['photo_name']}</label>";
                    else echo "<b>Zdjęcie</b> <input type='file' name='photo' id='file' accept='.png,.jpg,.jpeg'> <label for='file' id='fileLbl'>Dodaj zdjęcie</label>";
                ?>
                
            </div>
            <div class="cv-job-experience-education relative">
                <span class="title">
                    Edukacja i Doświadczenie
                    <div style="content: ''; position: absolute;left: 24.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 24.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <!-- DATA: Experience -->
                <b>Doświadczenie Zawodowe:</b> <button id="addExperience">Dodaj doświadczenie</button>
                <ul id="experienceList">
                <?php
                    if ($userData['experience'] != "") {
                        $experienceList = explode(";", $userData['experience']);
                        $i = 0;
                        foreach ($experienceList as $experience) {
                            $experienceValues = explode("\\", $experience);
                            if ($experienceValues[2] == "now") {
                                $now = date("Y-m-d");
                                echo "<li id='exp${i}'><input placeholder='Doświadczenie' maxlength='100' value='{$experienceValues[0]}' type='text' name='experience[name][$i]'> (<input type='date' value='{$experienceValues[1]}' name='experience[dateFrom][$i]' > do <input type='date' class='dateToClass' value='{$now}' name='experience[dateTo][$i]' disabled='disabled'> <label for='expDateToNow[$i]'>teraz <input type='checkbox' class='data-now' name='experience[dateTo][$i]' checked></label>)<i class='fa-solid fa-trash fa-xl delExp' id='delExp${i}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            }
                            else {
                                echo "<li id='exp${i}'><input placeholder='Doświadczenie' maxlength='100' value='{$experienceValues[0]}' type='text' name='experience[name][$i]'> (<input type='date' value='{$experienceValues[1]}' name='experience[dateFrom][$i]' > do <input type='date' class='dateToClass' value='{$experienceValues[2]}' name='experience[dateTo][$i]'> <label for='experience[dateTo][$i]'>teraz <input type='checkbox' class='data-now' name='experience[dateTo][$i]'></label>)<i class='fa-solid fa-trash fa-xl delExp' id='delExp${i}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            }
                            $i++;
                        }
                    }
                ?>
                </ul>
                <!-- DATA: Education -->
                <b>Edukacja:</b> <button id="addEducation">Dodaj edukacje</button>
                <ul id="educationList">
                <?php
                    if ($userData['education'] != "") {
                        $educationList = explode(";", $userData['education']);
                        $j = 0;
                        foreach ($educationList as $education) {
                            $educationValues = explode("\\", $education);
                            if ($educationValues[2] == "now") {
                                $now = date("Y-m-d");
                                echo "<li id='edu${j}'><input placeholder='Edukacja' maxlength='100' value='{$educationValues[0]}' type='text' name='education[name][$j]'> (<input type='date' value='{$educationValues[1]}' name='education[dateFrom][$j]' > do <input type='date' name='education[dateTo][$j]' value='{$now}' class='dateToClass' disabled='disabled'> <label for='education[dateTo][$j]'>teraz <input type='checkbox' class='data-now' name='education[dateTo][$j]' checked></label>)<i class='fa-solid fa-trash fa-xl delEdu' id='delEdu${j}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            }
                            else {
                                echo "<li id='edu${j}'><input placeholder='Edukacja' maxlength='100' value='{$educationValues[0]}' type='text' name='education[name][$j]'> (<input type='date' value='{$educationValues[1]}' name='education[dateFrom][$j]' > do <input type='date' name='education[dateTo][$j]' value='{$educationValues[2]}' class='dateToClass'> <label for='education[dateTo][$j]'>teraz <input type='checkbox' class='data-now' name='education[dateTo][$j]'></label>)<i class='fa-solid fa-trash fa-xl delEdu' id='delEdu${j}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            }
                            $j++;
                        }
                    }
                ?>
                </ul>
            </div>
            <div class="cv-abilities-interests relative">
                <span class="title">
                    Umiejętności i Zainteresowania
                    <div style="content: ''; position: absolute;left: 29.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 29.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <!-- DATA: Languages -->
                <b>Znajomość języków:</b> <button id="addLanguage">Dodaj język</button>
                <ul id="languageList">
                <?php
                    if ($userData['language_abilities'] != "") {
                        $languageList = explode(";", $userData['language_abilities']);
                        $k = 0;
                        foreach ($languageList as $language) {
                            $languageValues = explode('\\', $language);
                            echo "<li id='lan${k}'> <input placeholder='Język' maxlength='50' value='{$languageValues[0]}' type='text' name='language[name][$k]'> (<input placeholder='Poziom' maxlength='20' value='{$languageValues[1]}' type='text' name='language[level][$k]' >)<i class='fa-solid fa-trash fa-xl delLan' id='delLan${k}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            $k++;
                        }
                    }
                ?>
                </ul>
                <!-- DATA: Abilities -->
                <b>Umiejętności:</b> <button id="addSkill">Dodaj umiejętność</button>
                <ul id="skillList">
                <?php
                    if ($userData['abilities'] != "") {
                        $skillList = explode(";", $userData['abilities']);
                        $l = 0;
                        foreach ($skillList as $skill) {
                            echo "<li id='skill${l}'><input placeholder='Umiejętność' maxlength='50' value='$skill' type='text' name='skill[$l]'><i class='fa-solid fa-trash fa-xl delSkill' id='delSkill${l}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            $l++;
                        }
                    }
                ?>
                </ul>
                <!-- DATA: Interests -->
                <b>Zainteresowania:</b> <button id="addInterest">Dodaj zainteresowanie</button>
                <ul id="interestList">
                <?php
                    if ($userData['interests'] != "") {
                        $interestsList = explode(";", $userData['interests']);
                        $m = 0;
                        foreach ($interestsList as $interests) {
                            echo "<li id='int${m}'><input placeholder='Zainteresowanie' maxlength='50' value='$interests' type='text' name='interests[$m]'><i class='fa-solid fa-trash fa-xl delInt' id='delInt${m}' style='color: rgb(238, 110, 110); margin-left: 1rem;'></i></li>";
                            $m++;
                        }
                    }
                ?>
                </ul>
            </div>
            <div class="cv-description relative">
                <span class="title">
                    O mnie
                    <div style="content: ''; position: absolute;left: 7.96rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;"></div>
                    <div style="border-radius: 50%;content: '';position: absolute;left: 7.96rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;"></div>
                </span>
                <!-- DATA: About Me -->
                <textarea maxlength="500" style="resize: none" name="description" id="" cols="30" rows="10"><?php echo $userData['about_me'] ?></textarea>
            </div>
            <!-- DATA: Save CV -->
            <button type="submit" style="margin: 0;" id="save">Zapisz CV</button>
            <div id="errorBack">
                <div id="error-message">
                    <div id="error">Błąd po stronie serwera </div>
                    <button type="button" id="tryAgain">Spróbuj ponownie</button>
                </div>
            </div>
            <div style="margin-top: 1rem;">* - informacje obowiązkowe</div>
        </form>
        <br>
        <br>    
    </div>
</div>
</body>
</html>