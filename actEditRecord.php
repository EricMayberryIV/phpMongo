<?php
include 'db.php';
$id = $_SESSION['id'];
$collection = $db->vinyl;
echo "<pre>";
print_r($_POST);
echo "</pre>";

/**
 * if tracks or members are set, then updated database, otherwise don't
 * 
 */



if($_POST['title']!==null && !empty($_POST['title'])){
    $title = $_POST['title'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['title' => $title]]);
}

if($_POST['artist']!==null && !empty($_POST['artist'])){
    $artist = $_POST['artist'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['artist' => $artist]]);
}

if($_POST['genre']!==null && !empty($_POST['genre'])){
    $genre = $_POST['genre'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['genre' => $genre]]);
}

if($_POST['year']!==null && !empty($_POST['year'])){
    $year = $_POST['year'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['year' => $year]]);
}

if($_POST['label']!==null && !empty($_POST['label'])){
    $label = $_POST['label'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['label' => $label]]);
}

if($_POST['trackAmt']!==null && $_POST['trackAmt'] > 0){
    $tracks = $_POST['track'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['tracks' => $tracks]]);
}

/**
 * Updating members is not working currently
 * @todo Finish update of members
 */
if($_POST['memberAmt']!==null && $_POST['memberAmt'] > 0){
    $members = array_merge($_POST['member'],$_POST['instrument']);
    $membersUpdate = array('members' => array("name" => $_POST['member'],"instrument" => $_POST['instrument']));
    $collection->update($membersUpdate);
}

if($_POST['size']!==null && !empty($_POST['size'])){
    $size = $_POST['size'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['size' => $size]]);
}

if($_POST['speed']!==null && !empty($_POST['speed'])){
    $speed = $_POST['speed'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['speed' => $speed]]);
}

$b180 = $_POST['180'];
    $collection->update(['_id' => new MongoId("$id")], ['$set' => ['180' => $b180]]);

header('Location: ' . $_SERVER['HTTP_REFERER']);