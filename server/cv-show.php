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
        </div>";
    }
            
    $toReturn .= "
        <div class='cv-abilities-interests relative'>
                <span class='title'>
                    Umiejętności i Zainteresowania
                    <div style='content: \"\"; position: absolute;left: 29.5rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                    <div style='border-radius: 50%;content: \"\";position: absolute;left: 29.5rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
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
            <div class='cv-description relative'>
                <span class='title'>
                    O mnie
                    <div style='content: \"\"; position: absolute;left: 7.96rem;top: 1rem;width: 1rem;height: 1rem;background: #d9e2da;'></div>
                    <div style='border-radius: 50%;content: \"\";position: absolute;left: 7.96rem;top: 0.5rem;width: 1.5rem;height: 1.5rem;background: #ebf0eb;'></div>
                </span>
                Nazywam się Kononowicz Krzysztof. Urodziłem się dnia dwudziestego pierwszego stycznia tysiąc dziewięćset trzeciego… sześciesiątego trzeciego roku w Kętrzynie, woe… woewództwo olsztynskie. Chcę przedstawić swój życiorys. Ukończyłem zasadniczą szkołę zawodową jako kierowca-mechanik. Posiadam swoją posiadłość – domek drewniany. Mam matkę, mam brata. Tatuś ni żyje. Ale tatuś bardzo jest mój bardzo, bardzo zasłużony. Walczył o Warszawę, walczył o Polskę, walczył o Boga. Ale nie ma ojca – odeszedł. Jak ja mówię – powołał, zmienił miejsce zamieszkania. Jest w niebie teraz. I stamtąd patrzy, jak ja kandyduje na prezydenta miasta Białegostoku. Chcę zrobić dla naszego miasta Białegostoku następujące rzeczy. Zlikwidować całkowicie dla młodzieży alkohol, papierosy i narkotyki. Usprawnić w naszym Białymstoku komunikację miejską; miejską i dalekobieżną. Tak! Bo nasza komunikacja jest bardzo, bardzo słaba, bardzo zła. Otworzyć zakłady i miejsca pracy dla młodzieży i dla ludzi. Tak! I chcę bardzo, bardzo to zrobić. Usprawnić w naszym mieście, w całym, na całym Podlasiu, żeby nie było bandyctwa, żeby nie było złodziejstwa, żeby nie było niczego. Żeby starsi ludzie mogli przejść, bo nawet teraz dochodzi do mnie – skargi, postulaty, apelują starsze ludzie, w podeszłym wieku, że młodzież zaczepia. A ja się nie dziwię się, że młodzież starszych ludzi zaczepia, napada, napadają i tak dalej. Bo młodzież nie ma pracy, nie ma pracy! Zakłady nasze w Białymstoku są rozwalane, zanim zbudowane. Zamiast usprawnić Białystok, żeby miejsca pracy, tak jak Fasty są rozwalone, tak jak mleczarnie tu w Białymstoku, tak jak Spomasz w Starosielcach. Tak jak…. i inne zakłady są rozwalane. I chcę też wyprowadzić policje na ulice. Chcę wyprowadzić policje, żeby policja pilnowała całego naszego porządku, bo od tego jest policja i straż miejska. Od tego oni są! Od tego są oni! Od tego są. A w urzędzie u mie miejskim będzie ład i porządek. Ni będzie biurokractwa, ni będzie łachmactwa, tylko naprawdę ludzie będą. Zimową porą będą szykować architekci plany budowy dróg, plany budowy dróg. Podkreślam jeszcze raz: plany budowy dróg. A na wiosnę wyjdziemy z budową ulic i… ulic, bo jakie mamy drogi? Jakie mamy? Co się stao się pod Jeżewem? Co się stao się? A kierowcy też będą przez policję surowo karani, za alkohol, za papierosy, za wszystko. I jeszcze też usprawnię granice w Kuźnicy i Bobrownikach, że granica między Białorusią a nami będzie naprawdę, naprawdę będzie granica, że ni będzie przemytu, ani papierosów, ani narkotyków, ani alkoholu. Szanowne Państwo! Kandyduję z ramienia… Polasia XXI wieku. Bardzo proszę o oddanie na mnie głos. To co przedstawiłem, swoje postulaty, to ja wszystko uczynię i na mnie warto głosować, bo ja jestem naprawdę człowiekiem uczciwym i sprawiedliwym. Nie tak, że inne partie, inne komitety, inne partie mówią, a nic ni robią, a nic ni zrobili dla miasta Białegostoku, a to co ja powiedziałem to ja wszystko uczynię, bo jestem człowiekiem wierzącym i praktykującym i wiem na jakiej zasadzie to zrobić, jak uczynić, jak usprawnić drogi, jak wszystko, jak zlikwidować papierosy, jak wszystko zlikwidować. I bardzo proszę całego miasta Białegostoku i całego Podlasia oddać na mnie głos, dziękuję państwu.
            </div>
            <a href='cv-edit.php' id='edit'>Edytuj dane</a>
        </div>
    ";

    return $toReturn;
}
?>