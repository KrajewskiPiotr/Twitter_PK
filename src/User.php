<?php

class User {

    private $id;
    private $userName;
    private $hashPass;
    private $email;

    public function __construct() {
        $this->id = -1;
        $this->userName = "";
        $this->email = "";
        $this->hashPass = "";
    }

    function getId() {
        return $this->id;
    }

    function getUserName() {
        return $this->userName;
    }

    function getHashPass() {
        return $this->hashPass;
    }

    function getEmail() {
        return $this->email;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    public function setPassword($pass) {
        $hashPass = password_hash($pass, PASSWORD_BCRYPT);
        $this->hashPass = $hashPass;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    public function saveToDB(PDO $conn) {
        if ($this->id == -1) {
//Saving new user to DB
            $stmt = $conn->prepare(
                    'INSERT INTO users(userName, email, hash_pass) VALUES (:userName, :email, :pass)'
            );
            $result = $stmt->execute(
                    [ 'userName' => $this->userName, 'email' => $this->email, 'pass' => $this->hashPass]
            );
            if ($result !== false) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            $stmt = $conn->prepare(
                    'UPDATE users SET username=:username, email=:email, hash_pass=:hash_pass WHERE id=:id'
            );
            $result = $stmt->execute(
                    [ 'username' => $this->userName, 'email' => $this->email,
                        'hash_pass' => $this->hashPass, 'id' => $this->id]
            );
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    static public function loadUserById(PDO $conn, $id) {
        $stmt = $conn->prepare('SELECT * FROM users WHERE id=:id');
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->userName = $row['username'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];

            return $loadedUser;
        }
        return null;
    }

    static public function loadAllUsers(PDO $conn) {
        $stmt = "SELECT * FROM users";
        $ret = [];

        $result = $conn->query($stmt);
        if ($result !== false && $result->rowCount() > 0) {
            foreach ($result as $row) {
                $loadedUser = new User();
                $loadedUser->id = $row['id'];
                $loadedUser->userName = $row['username'];
                $loadedUser->hashPass = $row['hash_pass'];
                $loadedUser->email = $row['email'];
                $ret[] = $loadedUser;
            }
        }
        return $ret;
    }

    public function delete(PDO $conn) {
        if ($this->id != -1) {
            $stmt = $conn->prepare('DELETE FROM users WHERE id=:id');
            $result = $stmt->execute(['id' => $this->id]);
            if ($result === true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }

    static public function loadUserByEmail(PDO $conn, $email) {
        $stmt = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($stmt);
        if ($result == true && $result->rowCount() == 1) {
            $row = $result->fetch();
            $loadedUser = new User();
            $loadedUser->id = $row['id'];
            $loadedUser->userName = $row['username'];
            $loadedUser->hashPass = $row['hash_pass'];
            $loadedUser->email = $row['email'];
            return $loadedUser;
        }
        return null;
    }

    static public function logIn(PDO $conn, $email, $pass) {
        $loadedUser = self::loadUserByEmail($conn, $email);
        if (password_verify($pass, $loadedUser->hashPass)) {
            return $loadedUser;
        } else {
            return false;
        }
    }

}
