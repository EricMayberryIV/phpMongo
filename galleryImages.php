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
        //echo "<div class='card col-md-6 col-xl-4'>";
        //echo "<div class='card-body text-center'>";
        echo "<div>";
        echo "<img src='".$value."'  height='160' width='160' class='img-thumbnail'>";
        echo "</div>";
        //echo "</div>";
    }
    ?>
</div>