<?php
    if (!isset($_GET['userID']) || !isset($_GET['activationCode'])) {
        header("Location:../index.php");
        die;
    }

    if (!is_numeric($_GET['userID'])) {
        header("Location:../index.php");
        die;
    }

    $userID = $_GET['userID'];
    $activationCode = $_GET['activationCode'];

    require('../server/database-functions.php');

    $connect = database_connect_to_mysql();
    
    if (!$connect) {
        header("Location:../index.php");
        die;
    }

    $resultArray = "";
    if (!($resultArray = database_transaction($connect, 
            array(
                "SELECT * FROM account_activation WHERE user_id = $userID AND activation_code LIKE '$activationCode'",
                "SELECT account_type FROM accounts WHERE id = $userID"
            )
        )
    )) 
    {
        echo json_encode(array('success' => false, 'error' => array('type' => 'mysql_error', 'message' => "Wystąpił błąd po stronie serwera. Proszę spróbować ponownie za kilka minut.")));
        die;
    }

    if (!$resultArray[0]->num_rows >= 1) {
        header("Location:../index.php");
        die;
    }

    $accountType = $resultArray[1]->fetch_assoc()['account_type'];

    if (!($resultArray = database_transaction($connect, 
            array(
                "INSERT INTO user_{$accountType}s() VALUES ()",
                "UPDATE accounts SET accounts.id_user_data = (SELECT user_{$accountType}s.id FROM user_{$accountType}s ORDER BY user_{$accountType}s.id DESC LIMIT 1) WHERE accounts.id = $userID",
                "DELETE FROM account_activation WHERE user_id = $userID"
            )
        )
    )) 
    {
        header("Location:../index.php");
        die;
    }

    session_start();
    session_regenerate_id();
    $_SESSION['isLogged'] = true;
    $_SESSION['userID'] = $userID;
    $_SESSION['accountType'] = $accountType;
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
    <link rel="stylesheet" href="../assets/styles/activation.css">
    <title>JobSE</title>
</head>
<body>
    <nav>
        <div id="logo">JobSE <span>Job finding made easy</span></div>
    </nav>
    <div class="flex">
        <div id="text">
            <span style="font: 600 45px Poppins; color: #658667;">Gratulacje!</span>Twoje konto zostało aktywowane. <br>
            <span>Aby przejść na stronę panelu, <span id="highlight">kliknij w przycisk poniżej</span>.</span><br>
            <a href="../mainpage.php">Przejdź do panelu</a>
        </div>
    </div>
</body>
</html>