<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
echo 'Witaj ' . $_SESSION['userName'] . ' (Id: ' . $_SESSION['id'] . ')';
?>
<br>
<a href="logout.php">wyloguj się</a>
<br>
<a href="userPage.php">strona użytkownika</a>
<br>
<a href="editUser.php">edycja danych użytkonika</a>
<br>
<a href="allMessages.php">moje wiadomości </a>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'src/DBConnection.php';
    require_once 'src/Tweet.php';
    if (!empty($_POST['tweet'])) {


        $tweet = $_POST['tweet'];

        $newTweet = new Tweet();
        $newTweet->setUserId($_SESSION['id']);
        $newTweet->setText($tweet);
        if ($newTweet->saveToDB($conn)) {
            header("Location: main.php");
        } else {
            echo "Dodawanie tweeta nie powiodło się<br>";
        }
    }
}
?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
        <meta charset="utf-8"/>
        <title>Twitter</title>
    </head>
    <body>
        <hr>
        <div align="center"
             <form action="#" method="post" cols="200">
                <label>
                    Twój nowy Tweet <br> 
                    <textarea type="text" name="tweet" cols="90"> wpisz swój post</textarea>
                    <br>       
                    <input type="submit" value="publikuj Post" />
                </label>
            </form>
        </div>
        <hr>
        <p>
        <table border="2" cellpadding="5" align="center">
            <tr>
                <th width="600">Tweety</th>
                <th>Data publikacji</th>
            </tr>
            <tr>                 
                <td>                        
                    <?php
                    require_once 'src/Tweet.php';
                    require_once 'src/DBConnection.php';
                    require_once 'src/User.php';
                    $loadedTweets = Tweet::loadAllTweets($conn);
                    foreach ($loadedTweets as $tweet) {
                        echo "nr tweeta: " . $tweetId = $tweet->getId() . ' | ';
                        echo "Treść: " . $tweetText = $tweet->getText() . ' | ';
                        echo "<a href='tweetPage.php?postid=" . $tweet->getId() . "'>strona postu</a>" . " | ";
                        echo "id autora:" . $tweetUserId = $tweet->getUserId() . "<br>";
                    }
                    ?>
                </td>
                <td>  
                    <?php
                    foreach ($loadedTweets as $tweet) {
                        echo $tweet->getCreationDate();
                        echo '<br/>';
                    }
                    ?>
                </td>      
            </tr>
        </table>
    </p>
    <hr>


    <p>
    <table border="2" cellpadding="5" align="center">
        <tr>
            <th width="600">Użytkownicy</th>
            <th>Wyślij wiadomość</th>
        </tr>  
        <tr>
            <td>
                <?php
                $allUsers = User::loadAllUsers($conn);
                foreach ($allUsers as $user) {
                    echo $user->getUsername();
                    echo "<br>";
                }
                ?>
            </td>
            <td>
                <?php
                $tweetUser = $_SESSION['id'];
                foreach ($allUsers as $user) {
                    if ($user->getId() != $tweetUser) {
                        echo "<a href='writeMessage.php?userId=" . $user->getId() . "'>Wyslij Wiadomość</a>";
                        echo "<br>";
                    }
                }
                ?>
            </td>      
        </tr>


    </table> 
</p>
</body>
</html>
