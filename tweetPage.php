<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

require_once './src/Comment.php';
require_once './src/User.php';
require_once './src/Tweet.php';
require_once './src/DBConnection.php';





if (isset($_GET['postid'])) {
    $postid = $_GET['postid'];
    $tweet = Tweet::loadTweetById($conn, $postid);
    echo "nr tweeta: " . $tweetId = $tweet->getId() . ' | ';
    echo "Tweet: " . $tweetText = $tweet->getText() . ' | ';
    echo "nr autora:" . $tweetUserId = $tweet->getUserId() . "<br>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment = ($_POST['comment']);
        $commentUser = $_SESSION['id'];
        $newComment = new Comment();
        $newComment->setPostId($postid);
        $newComment->setUserId($commentUser);
        $newComment->setText($comment);
        $newComment->saveToDB($conn);
        if (!$newComment->saveToDB($conn)) {
            echo "Dodawanie komentarza nie powiodło się<br>";
        }
    }
    $comments = Comment::loadAllCommentsByPostId($conn, $postid);
    foreach ($comments as $comment) {
        echo "id autora: " . $iduser = $comment->getUserId() . ' | ';
        echo "nr tweeta: " . $idPost = $comment->getPostId() . ' | ';
        echo "Komentarz: " . $komentarz = $comment->getText() . ' | ';
        echo "Data dodania: " . $data = $comment->getCreation_date() . ' | ' . "<br>";
    }
}
?>

<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter - strona postu</title>
    </head>
    <body>
        <br>
        <a href="logout.php">wyloguj się</a>
        <br>
        <a href="userPage.php">strona użytkownika</a>
        <br>
        <a href="editUser.php">edycja danych użytkonika</a>
        <br>
        <a href="allMessages.php">moje wiadomości </a>
        <p>
        <form action="#" method="post" align="center" cols="200">
            <label>
                Twój nowy komentarz  
                <textarea type="text" name="comment" cols="90"> wpisz swój komentarz</textarea>
                <br>       
                <input type="submit" value="publikuj komentarz" />
            </label>
        </form>
    </p>
</body>
</html>