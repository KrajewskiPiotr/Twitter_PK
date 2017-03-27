<?php
session_start();
require_once './src/DBConnection.php';
require_once './src/User.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username'])) {
        $newUserName = trim(($_POST['username']));
    }
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - edycja danych</title>
    </head>
    <body>
        <br>
        <a href="logout.php">wyloguj się</a>
        <br>
        <a href="main.php">strona główna</a>
        <br>
        <form action="#" method="post" align="center">
            <fieldset>
                <strong>Wprowadz dane które chcesz zmienić w pola poniżej</strong><br>
                <label>
                    Nazwa użytkownika:<br>
                    <input type="text" name="username">
                </label>           
                <br>
                <label>
                    E-mail:<br>
                    <input type="text" name="email">
                </label>                       
                <br>
                <label>
                    Hasło:<br>
                    <input type="password" name="pass">
                </label>
            </fieldset>
            <br>
            <input type="submit" value="zmień dane">
        </form>
    </p>
</body>
</html>
