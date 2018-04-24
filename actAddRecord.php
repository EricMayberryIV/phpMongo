<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
$collection = $db->vinyl;

function before ($this, $inthat) {
    return substr($inthat, 0, strpos($inthat, $this));
};

function after ($this, $inthat) {
    if (!is_bool(strpos($inthat, $this)))
    return substr($inthat, strpos($inthat,$this)+strlen($this));
};

/**
 * initialize all database variables
 */

$url;
$title;
$artist;
$members;
$genre;
$year;
$label;
$tracks;
$size;
$speed;
$b180;


$title = $_POST['title'];
$artist = $_POST['artist'];
$genre = $_POST['genre'];
$year = $_POST['year'];
$year = (int)$year;
$label = $_POST['label'];
$size = $_POST['size'];
$size = (int)$size;
$speed = $_POST['speed'];
$speed = (int)$speed;
$b180 = $_POST['180'];


$time = time();
$rand = (rand(3,7)*$time);
$target_dir = "uploads/";
$target_file = $_FILES["fileToUpload"]["name"];
$target_file_rootname = before('.',$target_file);
$target_file = $target_file_rootname.$rand.".".after('.',$target_file);
if(!empty($_FILES["fileToUpload"]["name"])){
    $url = "uploads/" . $target_file;
} else {
    $url = '';
}
$temp_name = $_FILES["fileToUpload"]["tmp_name"];
if(isset($_POST['member'])){
    $members = array_combine($_POST['member'],$_POST['instrument']);
}
if(isset($_POST['track'])){
    //echo "\$tracks: ";
    $tracks = $_POST['track'];
}
echo "<hr/>";
var_dump($_POST);
echo "<hr/>";



if (!empty($_FILES["fileToUpload"]["name"])) {
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".<br/>";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br/>";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br/>";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.<br/>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br/>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br/>";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($temp_name, $url)) {
            echo "The file ". $target_file . " has been uploaded.<br/>";
        } else {
            echo "Sorry, there was an error uploading your file.<br/>";
        }
    }
}

// Insert into Database
$collection = $db->vinyl;

$document = array(
    "img_url" => $url, 
    "title" => $title, 
    "artist" => $artist,
    'members' => array("name" => $_POST['member'],"instrument" => $_POST['instrument']),
    "genre" => $genre,
    "year" => $year,
    "label" => $label,
    "tracks" => $tracks,
    "size" => $size,
    "speed" => $speed,
    "180" => $b180
  );
	
$collection->insert($document);
header("location: /"); //RIGHT HERE <--- UNCOMMENT TO MAKE IT WORK!!!!