<?php

require_once "DBInit.php";

class CommentDB {

    // Returns true if a valid combination of a username and a password are provided.
    public static function insert($journeyid, $userid, $comment ) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO comments (journeyid, userid, comment) 
            VALUES (:journeyid, :userid, :comment)");
        $statement->bindParam(":journeyid", $journeyid);
        $statement->bindParam(":userid", $userid);
        $statement->bindParam(":comment", $comment);
        $statement->execute();
    }

    public static function get($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT id, comment, commenttimestamp, journeyid, userid
            FROM comments 
            WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $journey = $statement->fetch();

        return $journey;
    }

    public static function getAllForJourney($journeyid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT username, comment, commenttimestamp, comments.userid, comments.id
            FROM comments 
            inner join users on comments.userid = users.id
            inner join journeys on comments.journeyid = journeys.id
            WHERE journeys.id = :journeyid
            order by commenttimestamp DESC");
        $statement->bindParam(":journeyid", $journeyid, PDO::PARAM_INT);
        $statement->execute();

        $journey = $statement->fetchAll();

        return $journey;
    }

    public static function deleteAll($journeyid) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM comments WHERE journeyid = :journeyid");
        $statement->bindParam(":journeyid", $journeyid, PDO::PARAM_INT);
        $statement->execute();
    }  

    public static function delete($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM comments WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }  

}
