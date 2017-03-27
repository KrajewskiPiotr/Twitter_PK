<?php

class Message {

    private $id;
    private $senderId;
    private $receiverId;
    private $status;
    private $creationDate;
    private $text;

    public function __construct() {
        $this->id = -1;
        $this->senderId = 0;
        $this->receiverId = 0;
        $this->status = 0;
        $this->setCreationDate('');
        $this->text = '';
    }

    public function getId() {
        return $this->id;
    }

    public function getSenderId() {
        return $this->senderId;
    }

    public function getReceiverId() {
        return $this->receiverId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreationDate() {
        return $this->creationDate;
    }

    public function getText() {
        return $this->text;
    }

    public function setSenderId($senderId) {
        $this->senderId = $senderId;
    }

    public function setReceiverId($receiverId) {
        $this->receiverId = $receiverId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setText($text) {
        $this->text = $text;
    }

    static public function LoadMessagesById(PDO $conn, $id) {
        $stmt = $conn->prepare('SELECT * From message WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result == true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedMessage = new Message();
            $loadedMessage->id = $row['id'];
            $loadedMessage->senderId = $row['senderId'];
            $loadedMessage->receiverId = $row['receiverId'];
            $loadedMessage->creationDate = $row['creationDate'];
            $loadedMessage->status = $row['status'];
            $loadedMessage->text = $row['text'];

            return $loadedMessage;
        }
        return null;
    }

    static public function LoadMessagesBySenderId(PDO $conn, $senderId) {

        $stmt = "SELECT * FROM message WHERE senderId=$senderId";
        $ret = [];
        $result = $conn->query($stmt);
        if ($result && $result->rowCount() > 0) {
            $allMessages = $result->fetchAll();
            foreach ($allMessages as $mess) {
                $loadedMess = new Message();
                $loadedMess->id = $mess['id'];
                $loadedMess->senderId = $mess['senderId'];
                $loadedMess->receiverId = $mess['receiverId'];
                $loadedMess->creationDate = $mess['creationDate'];
                $loadedMess->status = $mess['status'];
                $loadedMess->text = $mess['text'];
                $ret[] = $loadedMess;
            }
        }
        return $ret;
    }

    static public function LoadMessagesByReceiverId(PDO $conn, $receiverId) {

        $stmt = "SELECT * FROM message WHERE receiverId=$receiverId";
        $ret = [];
        $result = $conn->query($stmt);
        if ($result && $result->rowCount() > 0) {
            $allMessages = $result->fetchAll();

            foreach ($allMessages as $mess) {
                $loadedMess = new Message();
                $loadedMess->id = $mess['id'];
                $loadedMess->senderId = $mess['senderId'];
                $loadedMess->receiverId = $mess['receiverId'];
                $loadedMess->creationDate = $mess['creationDate'];
                $loadedMess->status = $mess['status'];
                $loadedMess->text = $mess['text'];

                $ret[] = $loadedMess;
            }
        }
        return $ret;
    }

    function saveToDB(PDO $conn) {
        if ($this->id == -1) {

            $stmt = $conn->prepare(
                    'INSERT INTO message VALUES (NULL, :senderId, :receiverId, NULL, :status, :text)'
            );
            $result = $stmt->execute(
                    [ 'senderId' => $this->senderId, 'receiverId' => $this->receiverId, 'status' => $this->status, 'text' => $this->text]
            );
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        }
        return false;
    }

}
