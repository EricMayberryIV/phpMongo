<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';
$id = $_GET['id'];
$_SESSION['id'] = $id;
if (empty($m)){
    if (empty($db)){
        die('Database connection is having issues<br/><br/>');
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Record Info</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Datatables -->
        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css"> -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.css"/>

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">


        <!-- Custom styles for this template -->
        <link href="assets/css/main.css" rel="stylesheet">
      </head>

      <body>
          <?php include 'header.php';?>
          <!-- Begin page content -->
          <main role="main" class="container">
              <div class="row">
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
                      echo "<div class='card col-md-6 col-lg-4'>";
                      echo "<div class='card-body text-center'>";
                      echo "<img class='card' src='".$value."'  height='300' width='300'>";
                      echo "</div>";
                      echo "</div>";
                  }
                  ?>
              </div>
          </main>
          <!-- Bootstrap core JavaScript
          ================================================== -->
          <!-- Placed at the end of the document so the pages load faster -->
          <script src="assets/js/jquery-slim.min.js"></script>
          <script>window.jQuery || document.write('<script src="assets/js/jquery-slim.min.js"><\/script>')</script>
          <script src="assets/js/popper.min.js"></script>
          <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>
