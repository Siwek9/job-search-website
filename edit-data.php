<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/styles/start_page.css">
    <script src="firm-edit.js" defer></script>
    <title>Edycja danych</title>
</head>
<body>
<div id="myData" style="height: auto;">
        <h1>Dane mojej firmy</h1>
        <div id="loginPass">
            <div id="firmData">
                <img src="assets/images/company-logo/56.png" alt="">
                <b>Właściciel*: </b> <span><input style="width: 20rem" placeholder="Właściciel" type="text" name="login" id=""></span>
                <b>Nazwa firmy*: </b> <span><input style="width: 20rem" placeholder="Właściciel" type="text" name="login" id=""></span>
                <b>Adres E-Mail: </b> <span><input placeholder="Email" type="email" name="email" id=""></span>
                <b>Adres*: </b> <span><input style="width: 20rem" placeholder="Właściciel" type="text" name="login" id=""></span>
                <b>Zdjęcie</b> <input type='file' name='photo' id='file' accept='.png,.jpg,.jpeg'> <span><label for='file' id='fileLbl'>Aktualne zdjęcie: </label></span>
                <b>Opis: </b> <span><textarea maxlength="500" style="resize: none" name="description" id="" cols="30" rows="10"></textarea></span> 
                <div style="display:flex; justify-content: center">
                    <a href='edit-data.php' id='edit' style="width: 8rem; margin-right: 1rem">Zapisz</a>
                </div>
                <div style="margin-top: 1rem; text-align:center">* - informacje obowiązkowe</div>
                <div id="errorBack">
                <div id="error-message">
                    <div id="error">Błąd po stronie serwera </div>
                    <button type="button" id="tryAgain">Spróbuj ponownie</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>