
<?php
session_start();
require_once './src/DBConnection.php';

require_once './src/Message.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
?>
Twoje ID: <?php echo $_SESSION['id']; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wiadomość</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <br>
        <a href="logout.php">wyloguj się</a>
        <br>
        <a href="main.php">strona główna </a>
        <br>


        <?php
        require_once './src/Message.php';
        $userLoged = $_SESSION['id'];
        echo 'Wiadomości wysłane' . '<br>';
        $messagesSender = Message::LoadMessagesBySenderId($conn, $userLoged);
        foreach ($messagesSender as $message) {
            echo "nr wysyłającego: " . $message->getSenderId() . ' | ';
            echo "nr otrzymującego: " . $message->getReceiverId() . ' | ';
            echo "Wiadomość: " . substr($message->getText(), 0, 30) . ' | ';
            echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
        }
        echo 'Wiadomości otrzymane' . '<br>';
        ?>
        <div>
            <?php
            $receiverId = $_SESSION['id'];
            $message = Message::LoadMessagesByReceiverId($conn, $receiverId);
            foreach ($message as $mess) {
                echo "nr wysyłającego: " . $mess->getSenderId() . ' | ';
                echo "nr otrzymującego: " . $mess->getReceiverId() . ' | ';
                echo "Wiadomość: " . substr($mess->getText(), 0, 30) . ' | ';
                echo "<a href='wholeMessage.php?messageId=" . $mess->getId() . "'>przeczytaj całą wiadomość</a>" . ' | ';
                echo "Data przesłania: " . $mess->getCreationDate() . ' | ' . "<br>";
            }
            ?>   
        </div>



    </body>
</html>