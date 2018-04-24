<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
$id = $_GET['id'];

if (empty($m)){
    if (empty($db)){
        die('Database connection is having issues<br/><br/>');
    }
}

$collection = $db->vinyl;
$record = $collection->remove(array('_id' => new MongoId($id)));
header('Location: /');