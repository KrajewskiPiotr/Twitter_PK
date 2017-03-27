<?php

class Comment {

    private $id;
    private $userId;
    private $postId;
    private $creation_date;
    private $text;

    public function __construct() {
        $this->id = -1;
        $this->userId = 0;
        $this->postId = 0;
        $this->creation_date = '';
        $this->text = '';
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getPostId() {
        return $this->postId;
    }

    public function getCreation_date() {
        return $this->creation_date;
    }

    public function getText() {
        return $this->text;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setPostId($postId) {
        $this->postId = $postId;
    }

    public function setCreation_date($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function setText($text) {
        $this->text = $text;
    }

    static public function loadCommentById(PDO $conn, $id) {

        $stmt = $conn->prepare('SELECT * FROM comment WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedComment = new Comment();
            $loadedComment->id = $row['id'];
            $loadedComment->userId = $row['userId'];
            $loadedComment->text = $row['text'];
            $loadedComment->creationDate = $row['creation_date'];
            $loadedComment->postId = $row['postId'];

            return $loadedComment;
        }
        return null;
    }

    static public function loadAllCommentsByPostId(PDO $conn, $postId) {

        $stmt = "SELECT * FROM comment WHERE postId=$postId";
        $ret = [];
        $result = $conn->query($stmt);
        if ($result == true && $result->rowCount() != 0) {
            foreach ($result as $row) {
                $loadedComment = new Comment();
                $loadedComment->id = $row['id'];
                $loadedComment->userId = $row['userId'];
                $loadedComment->text = $row['text'];
                $loadedComment->creationDate = $row['creation_date'];
                $loadedComment->postId = $row['postId'];
                $ret[] = $loadedComment;
            }
        }
        return $ret;
    }

    function saveToDB(PDO $conn) {

        if ($this->id == -1) {

            $stmt = $conn->prepare(
                    'INSERT INTO comment VALUES (NULL, :userId, :postId, NULL, :text)'
            );

            $result = $stmt->execute(
                    [ 'userId' => $this->userId, 'postId' => $this->postId, 'text' => $this->text]
            );
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE comment SET text=:text WHERE id=:id'
            );
            $result = $stmt->execute(
                    [ 'text' => $this->text, 'id' => $this->id]
            );
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

}
