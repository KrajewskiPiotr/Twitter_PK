<?php
session_start();
require_once './src/Tweet.php';
require_once './src/DBConnection.php';
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter User Posts</title>
    </head>
    <body>       
        Twoje ID: <?php echo $_SESSION['id']; ?>
<br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="main.php">strona główna </a>
<br>
        <p>
        <table border="2" cellspacing="6" cellpadding="5" align="center">
            <tr>
                <th width="600">Twój Tweet</th>
                <th>Data publikacji</th>
            </tr>
            <tr>
                <td> <?php
                    $id = $_SESSION['id'];
                    $loadedTweets = Tweet::loadAllTweetsByUserId($conn, $id);
                    foreach ($loadedTweets as $tweet) {
                        $tweetId = $tweet->getId();
                       // $numberComments = count(Comment::loadAllCommentsByPostId($conn, $tweetId));
                        echo "nr tweeta:" . $tweet->getId() . " | ";
                        echo "Tweet:" . $tweet->getText() . " | ";
                        echo "<a href='tweetPage.php?postid=" . $tweet->getId() . "'>strona postu</a>" . " | ";
                       // echo "liczba komentarzy:" . $numberComments . " | ";
                        echo "nr autora:" . $tweet->getUserId() . "<br>";
                    }
                    ?>
                </td>
                <td> <?php
                    foreach ($loadedTweets as $tweet) {
                        echo $tweet->getCreationDate();
                        echo "<br>";
                    }
                    ?>
                </td>
            </tr>
        </table >       
    </p>
</body>
</html>