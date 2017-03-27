<?php

class Tweet {

    private $id;
    private $userId;
    private $text;
    private $creationDate;

    public function __construct() {
        $this->id = -1;
        $this->userId = '';
        $this->text = '';
        $this->creationDate = '';
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getText() {
        return $this->text;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    static function loadTweetById(PDO $conn, $id) {

        $stmt = $conn->prepare('SELECT * FROM tweet WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedTweet = new Tweet();
            $loadedTweet->id = $row['id'];
            $loadedTweet->userId = $row['userId'];
            $loadedTweet->text = $row['text'];
            $loadedTweet->creationDate = $row['creationDate'];

            return $loadedTweet;
        }
        return null;
    }

    static function loadAllTweetsByUserId(PDO $conn, $userId) {

        $stmt = "SELECT * FROM tweet WHERE userId=$userId";
        $ret = [];
        $result = $conn->query($stmt);
        if ($result == true && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    static function loadAllTweets(PDO $conn) {

        $stmt = "SELECT * FROM tweet Order By `creationDate` Desc";
        $ret = [];

        $result = $conn->query($stmt);
        if ($result !== false && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedTweet = new Tweet();
                $loadedTweet->id = $row['id'];
                $loadedTweet->userId = $row['userId'];
                $loadedTweet->text = $row['text'];
                $loadedTweet->creationDate = $row['creationDate'];
                $ret[] = $loadedTweet;
            }
        }
        return $ret;
    }

    function saveToDB(PDO $conn) {

        if ($this->id == -1) {
//Saving new tweet to DB
            $stmt = $conn->prepare(
                    'INSERT INTO tweet(userId, text) VALUES (:userId, :text)'
            );
            $result = $stmt->execute(
                    [ 'userId' => $this->userId, 'text' => $this->text]
            );
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE tweet SET userId=:userId, text=:text, creationDate=:creationDate WHERE id=:id'
            );
            $result = $stmt->execute(
                    [ 'userId' => $this->userId, 'text' => $this->text,
                        'creationDate' => $this->creationDate, 'id' => $this->id]
            );
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

}
