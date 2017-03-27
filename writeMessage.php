<?php
session_start();
require_once './src/DBConnection.php';
require_once './src/User.php';
require_once './src/Message.php';


if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>
Twoje ID: <?php echo $_SESSION['id']; ?>
<br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="main.php">strona główna </a>
<br>
<?php
if (isset($_GET['userId']) && is_numeric($_GET['userId'])) {
    $receiverId = $_GET['userId'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = $_POST['message'];
        $messageId = $_SESSION['id'];
        $newMessage = new Message();
        $newMessage->setSenderId($messageId);
        $newMessage->setReceiverId($receiverId);
        $newMessage->setText($message);
        $newMessage->setStatus(0);
        if ($newMessage->saveToDB($conn)) {
            header("Location: allMessages.php");
        } else {
            echo "wysyłanie wiadomości nie powiodło się<br>";
        }
    }

    $conn = null;
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter</title>
    </head>
    <body>
        <form action="#" method="post" align="center" cols="200">
            <label>
                Twoja nowa wiadomość  
                <textarea type="text" name="message" cols="90"> wpisz swoją wiadomość</textarea>
                <br>       
                <input type="submit" value="wyślij wiadomość" />
            </label>
        </form>
    </p>
</body>
</html>