<?php

require_once "DBInit.php";

class UserDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function validLoginAttempt($username, $password) {
        $dbh = DBInit::getInstance();

        try {
            $stmt = $dbh ->prepare("SELECT * FROM users WHERE username = :username");
            $stmt -> bindValue(":username" , $username);
            $stmt -> execute();
        } catch ( PDOException $e ) {
            echo "An error occurred : { $e - > getMessage () }. " ;
        }

        $user = $stmt->fetch(0);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
        
    }

    public static function validSignupAttempt($data) {
        $hashed_password = password_hash($data['password'],PASSWORD_DEFAULT);
        $dbh = DBInit::getInstance();

        try {

            $stmt = $dbh ->prepare("SELECT count(id) FROM users WHERE username = :username");
            $stmt -> bindValue(":username" , $data['username']);
            $stmt -> execute();
            if($stmt->fetchColumn(0) > 0)
                return 1;
            
            $stmt = $dbh ->prepare("SELECT * FROM users WHERE email = :email");
            $stmt -> bindValue(":email" , $data['email']);
            $stmt -> execute();
            if($stmt->fetchColumn(0) > 0)
                return 2;
            
            $stmt = $dbh ->prepare("INSERT INTO users (username, password, name, surname, email) 
            VALUES (:username, :password, :name, :surname, :email)");
            $stmt -> bindValue(":username" , $data['username']);
            $stmt -> bindValue(":password" , $hashed_password);
            $stmt -> bindValue(":name" , $data['name']);
            $stmt -> bindValue(":surname" , $data['surname']);
            $stmt -> bindValue(":email" , $data['email']);
            $stmt -> execute();
        } catch ( PDOException $e ) {
            echo "An error occurred : { $e - > getMessage () }. " ;
        }
        return 0;
        
    }
}
