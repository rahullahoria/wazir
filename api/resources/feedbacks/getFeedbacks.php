<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 6/22/16
 * Time: 3:06 PM
 */


function getFeedbacks($userId, $objectId){

    $sql = "SELECT * FROM feedbacks WHERE object_id=:id ORDER BY `id` DESC ";
    $namesSql = "SELECT name FROM bluenet_v3.users WHERE id = :id";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindParam("id", $objectId);

        $stmt->execute();
        $feedbacks = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($feedbacks as $key => $feedback) {
            $id = $feedback->user_id;
            if($id == 0) $id = 1;
            $stmt = $db->prepare($namesSql);
        
            $stmt->bindParam("id", $id);
            
            $stmt->execute();
            $name = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $feedback->name = $name[0]['name'];
        }


        $db = null;

        echo '{"feedbacks": ' . json_encode($feedbacks) . '}';



    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}