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
        <a href="allMessages.php">strona wiadomości </a>
        <br>
        <?php
        if (isset($_GET['messageId']) && is_numeric($_GET['messageId'])) {
            $messageId = $_GET['messageId'];
            //$message = Message::changeMessageStatus($conn, $messageId);
            $userLogged = $_SESSION['id'];
            $messagesReceiver = Message::LoadMessagesByReceiverId($conn, $userLogged);
            foreach ($messagesReceiver as $message) {
                echo "nr wysyłającego: " . $message->getSenderId() . ' | ';
                echo "nr otrzymującego: " . $message->getReceiverId() . ' | ';
                echo "Wiadomość: " . $message->getText() . ' | ';
                echo "Data przesłania: " . $message->getCreationDate() . ' | ' . "<br>";
                echo "</div>";
            }
        } 