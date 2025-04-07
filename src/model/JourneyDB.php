<?php

require_once "DBInit.php";

class JourneyDB {

    public static function getForIds($ids) {
        $db = DBInit::getInstance();

        $id_placeholders = implode(",", array_fill(0, count($ids), "?"));

        $statement = $db->prepare("SELECT id, author, title, description, price, year, quantity
            FROM book WHERE id IN (" . $id_placeholders . ")");
        $statement->execute($ids);

        return $statement->fetchAll();
    }

    public static function getAll() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, title, description, picture, postTimestamp
            FROM journeys");
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT journeys.id, title, description, picture, postTimestamp, name, surname, userid, username
            FROM journeys inner join users on journeys.userid = users.id WHERE journeys.id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $journey = $statement->fetch();

        return $journey;

    }

    public static function insert($title, $description, $picture , $userid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO journeys (title, description, picture, userid) 
            VALUES (:title, :description, :picture, :userid)");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":picture", $picture);
        $statement->bindParam(":userid", $userid, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function update($title, $description, $picture, $id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE journeys SET title = :title, 
            description = :description, picture = :picture
            WHERE id = :id");
        $statement->bindParam(":title", $title);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":picture", $picture);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM journeys WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }    

    public static function search($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, title, description, picture, postTimestamp
            FROM journeys WHERE title like :query");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }    
}
