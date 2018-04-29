<?php
include 'db.php';
if (empty($m)){
    if (empty($db)){
        die('Database connection is having issues<br/><br/>');
    }
}
$collection = $db->vinyl;
?>

<div class="row justify-content-center">
    <?php
    $dir    = '/uploads';
    $files = opendir($dir);
    $dir_open = opendir('./uploads');
    $count = 0;
    while (false !== ($filename = readdir($dir_open))){
        if ($filename != "." &&
            $filename != ".." &&
            $filename != "placeholder.svg"){
            $files[$count] = $filename;
            $count++;
        }
  
    }
    
    
    shuffle($files);
    foreach($files as &$value){
        $value = 'uploads/'.$value;
        $record = $collection->findOne(array('img_url' => $value));
        echo "<div>";
        echo "<a href=info.php?id=".$record['_id']."><img src='".$value."'  height='160' width='160' class='img-thumbnail'></a>";
        echo "</div>";
    }
    ?>
</div>