<?php
function cvShow($userData) {
    $codes = require('world.php');

    $codes = array_values($codes);
    $nationalityID = array_search($userData['nationality'], array_column($codes, 'alpha2'));
    $nationalityName = $codes[$nationalityID]['name'];
    $toReturn =  "
        <div class='cv'>
            <div class='cv-photo'>";
    if (!is_null($userData['photo_name'])) {
        $toReturn .= "<img class='image' src='assets/images/cv-photo/{$userData['photo_name']}' alt='' draggable='false'>";
    }
                
    $toReturn .= "</div>
            <div class='cv-name'>{$userData['first_name']} {$userData['last_name']}
            </div>
            <div class='cv-info relative'>
                <span class='title relative'>
                    Informacje
                    <div style='content: \"\"; position: absolute;left: 11.3rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                    <div style='border-radius: 50%;content: \"\";position: absolute;left: 11.3rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
                </span>
                
                <b>Data urodzenia: </b>{$userData['birth_date']}<br>
                <b>E-mail: </b>{$userData['birth_date']}<br>
                <b>Narodowość: </b>{$nationalityName}<br>";
                if (!is_null($userData['phone_number'])) {
                    $toReturn .= "<b>Number telefonu: </b> {$userData['phone_number']}";
                }
    $toReturn .= "</div>";
    if (!is_null($userData['experience']) || !is_null($userData['education'])) {
        $toReturn .= "
        <div class='cv-job-experience-education relative'>
            <span class='title'>";
        if (!is_null($userData['education'])) {
            $toReturn .= "Edukacja";
        }
        if (!is_null($userData['experience']) && !is_null($userData['education'])) {
            $toReturn .= " i ";
        }
        if (!is_null($userData['experience'])) {
            $toReturn .= "Doświadczenie";
        }
            $toReturn .= "
            <div style='content: \"\"; position: absolute;left: 24.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                <div style='border-radius: 50%;content: \"\";position: absolute;left: 24.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
            </span>";
        if (!is_null($userData['experience'])) {
            $toReturn .= "<b>Doświadczenie Zawodowe:</b>
            <ul>";
            $experienceList = explode(";", $userData['experience']);
            foreach ($experienceList as $experience) {
                $experienceValues = explode("\\", $experience);
                if ($experienceValues[1] == "") {
                    $experienceValues[1] = "------";
                }
                if ($experienceValues[2] == "") {
                    $experienceValues[2] = "------";
                }
                if ($experienceValues[2] == "now") {
                    // $now = date("Y-m-d");
                    $toReturn .= "<li>{$experienceValues[0]} ({$experienceValues[1]} <b>do</b> teraz)</li>";
                }
                else {
                    $toReturn .= "<li>{$experienceValues[0]} ({$experienceValues[1]} <b>do</b> {$experienceValues[2]})</li>";
                }
            }
            $toReturn .= "</ul>";
        }
        if (!is_null($userData['education'])) {
            $toReturn .= "<b>Doświadczenie Zawodowe:</b>
            <ul>";
            $educationList = explode(";", $userData['education']);
            foreach ($educationList as $education) {
                $educationValues = explode("\\", $education);
                if ($educationValues[1] == "") {
                    $educationValues[1] = "------";
                }
                if ($educationValues[2] == "") {
                    $educationValues[2] = "------";
                }
                if ($educationValues[2] == "now") {
                    // $now = date("Y-m-d");
                    $toReturn .= "<li>{$educationValues[0]} ({$educationValues[1]} <b>do</b> teraz)</li>";
                }
                else {
                    $toReturn .= "<li>{$educationValues[0]} ({$educationValues[1]} <b>do</b> {$educationValues[2]})</li>";
                }
            }
            $toReturn .= "</ul>";
        }
        $toReturn .= "</div>";
    }
    if (!is_null($userData['language_abilities']) || !is_null($userData['abilities']) || !is_null($userData['interests'])) {
        $toReturn .= "
        <div class='cv-abilities-interests relative'>
            <span class='title'>";
        if (!is_null($userData['abilities'] || $userData['language_abilities'] )) {
            $toReturn .= "Umiejętności";
        }
        if ((!is_null($userData['abilities'] || $userData['language_abilities'] )) && !is_null($userData['education'])) {
            $toReturn .= " i ";
        }
        if (!is_null($userData['interests'])) {
            $toReturn .= "Zainteresowania";
        }
        $toReturn .= "<div style='content: \"\"; position: absolute;left: 29.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                <div style='border-radius: 50%;content: \"\";position: absolute;left: 29.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
            </span>";
        if (!is_null($userData['language_abilities'])) {
            $toReturn .= "<b>Znajomość języków:</b>
            <ul>";
            $languageList = explode(";", $userData['language_abilities']);
            foreach ($languageList as $language) {
                $languageValues = explode("\\", $language);
                $toReturn .= "<li>{$languageValues[0]} ({$languageValues[1]})</li>";

            }
            $toReturn .= "</ul>";
        }
        if (!is_null($userData['abilities'])) {
            $toReturn .= "<b>Umiejętności:</b>
            <ul>";
            $abilitiesList = explode(";", $userData['abilities']);
            foreach ($abilitiesList as $ability) {
                $toReturn .= "<li>{$ability}</li>";
            }
            $toReturn .= "</ul>";
        }
        if (!is_null($userData['interests'])) {
            $toReturn .= "<b>Zainteresowania:</b>
            <ul>";
            $interestsList = explode(";", $userData['interests']);
            foreach ($interestsList as $interest) {
                $toReturn .= "<li>{$interest}</li>";
            }
            $toReturn .= "</ul>";
        }
        $toReturn .= "</div>";
    }
    if (!is_null($userData['about_me'])) {
        $toReturn .= "
            <div class='cv-description relative'>
                <span class='title'>
                    O mnie
                    <div style='content: \"\"; position: absolute;left: 7.96rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                    <div style='border-radius: 50%;content: \"\";position: absolute;left: 7.96rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
                </span>
                {$userData['about_me']}
            </div>";
    }
    $toReturn .= "
            <a href='cv-edit.php' id='edit'>Edytuj dane</a>
        </div>
    ";

    return $toReturn;
}
?>