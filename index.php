

<?php
session_start();
if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true) {
    header("Location: main.php");
    exit();
}
require_once 'src/User.php';
require_once 'src/DBConnection.php';
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    if (isset($_POST['email'], $_POST['pass'])) {

        $sql = 'Select * From `users` Where `email` = :email;';

        $sqlParams = ['email' => $_POST['email']];

        try {
            $query = $conn->prepare($sql);
            $result = $query->execute($sqlParams);
            $row = $query->fetch();

            if (password_verify($_POST['pass'], $row['hash_pass']) && $query->rowcount() > 0) {

                $_SESSION['zalogowany'] = true;

                $_SESSION['id'] = $row['id'];
                $_SESSION['userName'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                header("Location: main.php");
            } else {
                $_SESSION['error'] = "Użytkownik lub hasło niepoprawne!";
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Twitter</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <div>
            <div>
                <h1>Twitter</h1>
            </div>
            <div>
                <div>
                    <form method="post">
                        <div>
                            <input type="text" name="email" placeholder="E-mail"/>
                        </div>
                        <div>
                            <input type="password" name="pass" placeholder="Hasło"/>
                        </div>
                        <button type='submit'>Zaloguj</button>
                    </form>
                </div>
                <div>
                    <form method='post' action='register.php'>
                        <button>Załóż nowe konto</button>
                    </form>
                </div>
            </div>

        </div>

    </body>
</html>

