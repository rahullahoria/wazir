<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 6/22/16
 * Time: 3:06 PM
 */


function getFeedbacks($userId, $objectId){

    $sql = "SELECT count(*) AS count, type FROM feedbacks WHERE object_id=:id GROUP BY type ";

    try {
        $db = getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindParam("id", $objectId);
        $stmt->execute();
        $counts = $stmt->fetchAll(PDO::FETCH_OBJ);


        $db = null;

        echo '{"counts": ' . json_encode($counts) . '}';



    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}