<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 6/22/16
 * Time: 3:06 PM
 */

function saveFeedback($userId, $objectId){

    $request = \Slim\Slim::getInstance()->request();
    $feedback = json_decode($request->getBody());

    $feedback->type = isset($feedback->type)?$feedback->type:'suggestion';
    $feedback->name = isset($feedback->name)?$feedback->name:'Rahul';
    $feedback->number = isset($feedback->number)?$feedback->number:'9599075955';

    $sqlCheckUser = "SELECT id FROM users WHERE name = :name AND mobile = :mobile ;";
    $sqlInsertUser = "INSERT INTO users (name, mobile, username, password, type) 
                        VALUES (:name, :mobile, :mobile, :mobile, 'candidate') ;";
    $sql = "INSERT INTO `wazir`.`feedbacks` ( object_id, user_id, feedback, type, digieye_user_id )
                    VALUES (:object_id, :user_id, :feedback, :type, :digieye_user_id );";
    try {

        $db = getDB();
        $stmt = $db->prepare($sqlCheckUser);
        $stmt->bindParam("name", $feedback->name);
        $stmt->bindParam("mobile", $feedback->number);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $newUserId = $data[0]['id'];
        if(!isset($newUserId)){
            $stmt = $db->prepare($sqlInsertUser);
            $stmt->bindParam("name", $feedback->name);
            $stmt->bindParam("mobile", $feedback->number);
            $stmt->execute();
            $newUserId = $db->lastInsertId();
        }

        $stmt = $db->prepare($sql);

        $stmt->bindParam("object_id", $objectId);
        $stmt->bindParam("user_id", $newUserId);

        $stmt->bindParam("feedback", $feedback->feedback);
        $stmt->bindParam("type", $feedback->type);
        $stmt->bindParam("digieye_user_id", $feedback->digieye_user_id);
        $stmt->execute();

        $id = $db->lastInsertId();
        $feedback->id = $id;
        $db = null;
        echo '{"feedback": ' . json_encode($feedback) . '}';
        
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":"' . $e->getMessage() . '"}}';
    }
}

?>
