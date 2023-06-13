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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="server/country-select-js/css/countrySelect.css">
    <script src="server/country-select-js/js/countrySelect.min.js"></script>
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
                <img class="image" src="assets/images/cv-photo/<?php echo $userData['photo_name'] ?>" alt="" draggable="false">
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
                
                <b>Data urodzenia*: </b> <input type="date" name="dataOfBirth" value="<?php echo $userData['birth_date']; ?>" id=""> <br>
                <b>E-mail*:</b> <input placeholder="E-Mail" type="email" name="email" value="<?php echo $userData['contact_email']; ?>" id=""> <br>
                <b>Narodowość*:</b> <input type="text" name="nationality" id="country"> <br>
                <script>
                    $("#country").countrySelect({
                        defaultCountry: "<?php echo $userData['nationality'] ?>",
                        preferredCountries: ["pl", "gb", "us", "ua", "de"]
                    });
                </script>
                <b>Number telefonu*:</b> <input placeholder="Numer telefonu" type="tel" name="tel" value="<?php echo $userData['phone_number']; ?>" id=""> <br> <br>
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
                <?php
                    if ($userData['experience'] != "") {
                        $experienceList = explode(";", $userData['experience']);
                        $i = 0;
                        foreach ($experienceList as $experience) {
                            $experienceValues = explode("\\", $experience);
                            if ($experienceValues[2] == "now") {
                                echo "<li><input placeholder='Doświadczenie' value='{$experienceValues[0]}' type='text' name='exp[$i]'> (<input type='date' value='{$experienceValues[1]}' name='expDateFrom[$i]' > do <input type='date' class='dateToClass' value='{$experienceValues[2]}' name='expDateTo[$i]' disabled='disabled'> <label for='expDateToNow[$i]'>teraz <input type='checkbox' class='data-now' name='expDateTo[$i]' checked></label>)</li>";
                            }
                            else {
                                echo "<li><input placeholder='Doświadczenie' value='{$experienceValues[0]}' type='text' name='exp[$i]'> (<input type='date' value='{$experienceValues[1]}' name='expDateFrom[$i]' > do <input type='date' class='dateToClass' value='{$experienceValues[2]}' name='expDateTo[$i]'> <label for='expDateToNow[$i]'>teraz <input type='checkbox' class='data-now' name='expDateTo[$i]'></label>)</li>";
                            }
                            $i++;
                        }
                    }
                ?>
                </ul>
                <b>Edukacja:</b> <button id="addEducation">Dodaj edukacje</button>
                <ul id="educationList">
                <?php
                    if ($userData['education'] != "") {
                        $educationList = explode(";", $userData['education']);
                        $j = 0;
                        foreach ($educationList as $education) {
                            $educationValues = explode("\\", $education);
                            if ($educationValues[2] == "now") {
                                echo "<li><input placeholder='Edukacja' value='{$educationValues[0]}' type='text' name='edu[$j]'> (<input type='date' value='{$educationValues[1]}' name='eduDateFrom[$j]' > do <input type='date' name='eduDateTo[$j]' value='{$educationValues[2]}' class='dateToClass' disabled='disabled'> <label for='eduDateTo[$j]'>teraz <input type='checkbox' class='data-now' name='eduDateTo[$j]' checked></label>)</li>";
                            }
                            else {
                                echo "<li><input placeholder='Edukacja' value='{$educationValues[0]}' type='text' name='edu[$j]'> (<input type='date' value='{$educationValues[0]}' name='eduDateFrom[$j]' > do <input type='date' name='eduDateTo[$j]' value='{$educationValues[2]}' class='dateToClass'> <label for='eduDateTo[$j]'>teraz <input type='checkbox' class='data-now' name='eduDateTo[$j]'></label>)</li>";
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
                <b>Znajomość języków:</b> <button id="addLanguage">Dodaj język</button>
                <ul id="languageList">
                <?php
                    if ($userData['language_abilities'] != "") {
                        $languageList = explode(";", $userData['language_abilities']);
                        $k = 0;
                        foreach ($languageList as $language) {
                            $languageValues = explode('\\', $language);
                            echo "<li><input placeholder='Język' value='{$languageValues[0]}' type='text' name='lan[$k]'> (<input placeholder='Poziom' value='{$languageValues[1]}' type='text' name='lanLevel[$k]' >)</li>";
                            $k++;
                        }
                    }
                ?>
                </ul>
                <b>Umiejętności:</b> <button id="addSkill">Dodaj umiejętność</button>
                <ul id="skillList">
                <?php
                    if ($userData['abilities'] != "") {
                        $skillList = explode(";", $userData['abilities']);
                        $l = 0;
                        foreach ($skillList as $skill) {
                            echo "<li><input placeholder='Umiejętność' value='$skill' type='text' name='skill[$l]'></li>";
                            $l++;
                        }
                    }
                ?>
                </ul>
                <b>Zainteresowania:</b> <button id="addInterest">Dodaj zainteresowanie</button>
                <ul id="interestList">
                <?php
                    if ($userData['interests'] != "") {
                        $interestsList = explode(";", $userData['interests']);
                        $m = 0;
                        foreach ($interestsList as $interests) {
                            echo "<li><input placeholder='Zainteresowanie' value='$interests' type='text' name='interests[$m]'></li>";
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
                <textarea style="resize: none" name="desc" id="" cols="30" rows="10"><?php echo $userData['about_me'] ?></textarea>
            </div>
            <div id="error-message"></div>
            <button id="save">Zapisz CV</button>
        </form>
        <br>
        <br>    
    </div>
</div>
</body>
</html>