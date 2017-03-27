<?php
session_start();
require_once './src/DBConnection.php';
require_once './src/User.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['userName']) && isset($_POST['email']) && isset($_POST['pass'])) {
        $userName = trim($_POST['userName']);
        $email = trim($_POST['email']);
        $pass = trim($_POST['pass']);

        $user = User::loadUserByEmail($conn, $email);

        if (!$user) {
            $newUser = new User();
            $newUser->setEmail($email);
            $newUser->setPassword($pass);
            $newUser->setUserName($userName);
            if ($newUser->saveToDB($conn)) {
                echo "Rejestracja zakończona pomyślnie, za chwilę zostaniesz przekierowany na stronę logowania";
                header("refresh:5;url=index.php");
            } else {
                echo "Rejestracja nie powiodła się<br>";
            }
        } else {
            if ($user) {
                echo "Podany adres e-mail istnieje w bazie danych<br>";
            } else {
                echo 'Nieprawidłowe dane<br>';
            }
        }
        $conn = null;
    }
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
                <h3>Rejestracja nowego użytkownika</h3>
            </div>
            <div>
                <div>
                    <form method="post">
                        <div>
                            <input type="text" name="userName" placeholder="Name"/>
                        </div>
                        <div>
                            <input type="text" name="email" placeholder="E-mail"/>
                        </div>
                        <div>
                            <input type="password" name="pass" placeholder="Hasło"/>
                        </div>
                        <button type='submit'>Zarejestruj się</button>
                    </form>
                </div>

            </div>

        </div>

    </body>
</html>