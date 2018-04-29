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
        <div>&nbsp;</div>
        <div>
            <div class="row">
                <div class="col-lg-4">
                    <?php
                    $collection = $db->vinyl;
                    $record = $collection->findOne(array('_id' => new MongoId($id)));
                    if (empty($record['img_url'])){
                        echo "<img src='uploads/placeholder.svg' height='300' width='300'>";
                    } else {
                        echo "<img src='".$record['img_url']."' height='300' width='300'>";
                    }
                    ?>
                </div>
                <div class="col-lg-8">
                    <?php
                    echo "<h1>".$record['artist']."</h1>";
                    echo "<h2>".$record['title']."</h2><br/>";
                    echo "<p><span class='h5'>Year: ".$record['year']."</span><br/>";
                    echo "<span class='h5'>Genre: ".$record['genre']."</span><br/>";
                    echo "<span class='h5'>Label: ".$record['label']."</span></p>";
                    ?>
                    <div class="row">
                        <div class="col-3">
                            <?php echo "<span class='h6'>Size ".$record['size']."\"</span>"; ?>
                        </div>
                        <div class="col-5">
                            <?php echo "<span class='h6'>Speed ".$record['speed']."rpm</span>"; ?>
                        </div>
                        <div class="col-4">
                            <?php 
                            if ($record['180']==true){
                                echo "<span class='h6'>180g? &nbsp;<i class='far fa-check-square'></i></span>";
                            } else {
                                echo "<span class='h6'>180g? &nbsp;<i class='far fa-square'></i></span>";
                            } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($record['tracks']!==null){
                echo "<br/>";
                echo "<ul class='list-group collapsed accordion' data-toggle='collapse' data-target='#collapseOne' aria-controls='collapseOne'>";
                echo "<li class='list-group-item active'>Tracks</li>";
                echo "<div id='collapseOne' class='collapse' aria-labelledby='headingOne' data-parent='#accordion'>";
                $count = 1;
                foreach ($record['tracks'] as &$track) {
                    echo "<li class='list-group-item'>".$count.") ".$track."</li>";
                    $count++;
                }
                echo "</div>";
                echo "</ul>";
            } else {
            }
            if ($record['members']['name']!==null){
                echo "<br/>";
                echo "<ul class='list-group collapsed accordion' data-toggle='collapse' data-target='#collapseTwo' aria-controls='collapseTwo'>";
                echo "<li class='list-group-item active'>Members</li>";
                echo "<div id='collapseTwo' class='collapse' aria-labelledby='headingTwo' data-parent='#accordion'>";
                $max = sizeof($record['members']['name']);
                for ($row = 0; $row < $max; $row++) {
                  echo "<li class='list-group-item'>".$record['members']['name'][($row+1)]." - ".$record['members']['instrument'][($row+1)]."</li>";;
                }
                
                echo "</div>";
                echo "</ul>";
            } else {
            }
            ?>
        </div>
        <br/>
        <?php
        if(isset($record['tracks'])){
            $numTracks = sizeof($record['tracks']);
        } 
        if(isset($record['members']['name'])){
            $numMembers = sizeof($record['members']['name']);
        } 
        ?>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href='/' class='btn btn-outline-secondary'>Back</a>
            <a href='DeleteRecord.php?id=<?php echo $id; ?>' class='btn btn-outline-danger'>Delete</a>
            <button class='btn btn-outline-primary' data-toggle="modal" data-target="#editModal">Edit</button>
        </div>
            
        <br/>&nbsp;
        <!-- Delete Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editLabel">Edit Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form enctype="multipart/form-data" class="form-signin" action="actEditRecord.php" method="post">
                      <input type="file" name="fileToUpload" id="fileToUpload">
                      <br/>
                      <label for="inputTitle">Title</label>
                      <input type="text" name="title" id="inputTitle" class="form-control" value="<?php echo $record['title']; ?>">
                      <br/>
                      <label for="inputArtist">Artist</label>
                      <input type="text" name="artist" id="inputArtist" class="form-control" value="<?php echo $record['artist']; ?>">
                      <br/>
                      <label for="inputGenre">Genre</label>
                      <?php $genre = $record['genre']; ?>
                      <select class="form-control" name="genre" id="inputGenre">
                          <option value='<?php echo $genre; ?>' selected='selected'><?php echo $genre; ?></option>
                          <?php
                          $collGenre = $db->genre;
                          $cursor = $collGenre->find();
                          $cursor->sort(array('genre_name' => 1));
                          $selected = ((strtolower($record["genre_name"]) == 'default') ? 'selected' : '');
                          foreach ($cursor as $document) {
                              echo '<option value="' . $document["genre_name"] . '">' . $document["genre_name"] . '</option>';
                          }
                          ?>
                      </select>
                      <br/>
                      <?php 
                      $thisYear = date("Y");
                      $thisYear = (int)$thisYear;
                      ?>
                      <label for="inputYear">Year</label>
                      <?php $year = $record['year']; ?>
                      <select class="form-control" name="year" id="inputYear">
                          <option value='<?php echo $year; ?>' selected='selected'><?php echo $year; ?></option>
                          <?php
                          for ($i = $thisYear; $i >= 1900; $i--) {
                              echo '<option value="' . $i . '">' . $i . '</option>';
                          }
                          ?>
                      </select>
                      <br/>
                      <label for="inputLabel">Label</label>
                      <?php $label = $record['label']; ?>
                      <select class="form-control" name="label" id="inputLabel">
                          <option value='<?php echo $label; ?>' selected='selected'><?php echo $label; ?></option>
                          <?php
                          $collCo = $db->company;
                          $cursor = $collCo->find();
                          $cursor->sort(array('co_name' => 1));
                          foreach ($cursor as $document) {
                              echo '<option value="' . $document["co_name"] . '">' . $document["co_name"] . '</option>';
                          }
                          ?>
                      </select>
                      <br/>
                      <label for="trackAmt">Tracks</label>
                      <input type="text" id="trackAmt" value="" name="trackAmt" onchange="addFieldsTracks();">
                      <br/>
                      <div id="trackList">
                      </div>
                      <br/>
                      <label for="memberAmt">Members</label>
                      <input type="text" id="memberAmt" value="" name="memberAmt" onchange="addFieldsMember();">
                      <br />
                      <div id="memberList">
                      </div>
                      <br/>
                      <label for="inputSize">Size</label>
                      <?php $size = $record['size']; ?>
                      <select class="form-control" name="size" id="inputSpeed">
                          <option value="" <?php if (!empty($size) && $size == '' ) echo 'selected = "selected"'; ?>></option>
                          <option value="7" <?php if (!empty($size) && $size == 7)  echo 'selected = "selected"'; ?>>7"</option>
                          <option value="10" <?php if (!empty($size) && $size == 10)  echo 'selected = "selected"'; ?>>10"</option>
                          <option value="12" <?php if (!empty($size) && $size == 12)  echo 'selected = "selected"'; ?>>12"</option>
                      </select>
                      <br/>
                      <label for="inputSpeed">Speed</label>
                      <?php $speed = $record['speed']; ?>
                      <select class="form-control" name="speed" id="inputSpeed">
                          <option value="" <?php if (!empty($speed) && $speed == '' ) echo 'selected = "selected"'; ?>></option>
                          <option value="33" <?php if (!empty($speed) && $speed == 33)  echo 'selected = "selected"'; ?>>33rpm</option>
                          <option value="45" <?php if (!empty($speed) && $speed == 45)  echo 'selected = "selected"'; ?>>45rpm</option>
                          <option value="78" <?php if (!empty($speed) && $speed == 78)  echo 'selected = "selected"'; ?>>78rpm</option>
                      </select>
                      <br/>
                      <div class="form-check">
                          <?php
                          if ($record['180']==true){
                              echo "<input class='form-check-input' type='checkbox' value='true' id='input180' name='180' checked>";
                          } else {
                              echo "<input class='form-check-input' type='checkbox' value='true' id='input180' name='180'>";
                          }
                          ?>
                        <label class="form-check-label" for="input180">
                          180g
                        </label>
                      </div>
                      <div class="btn-group float-right" role="group">
                          <button class="btn btn-outline-primary" type="reset">Reset</button>
                          <button class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                          <button class="btn btn-outline-success" type="submit" name="submit">Edit</button>
                      </div>
                  </form>
              </div>
              
            </div>
          </div>
        </div>
    </main>
      
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery-slim.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
      
      <?php
      echo '<script>';
      echo 'var name = ' . json_encode($record['tracks']) . ';';
      echo '</script>';
      ?>
      
    <script>
        function addFieldsTracks(){
            var number = document.getElementById("trackAmt").value;
            var container = document.getElementById("trackList");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                container.appendChild(document.createTextNode((i+1)));
                var input = document.createElement("input");
                input.type = "text";
                input.name = "track["+(i+1)+"]";
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
            }
        }
        
        function addFieldsMember(){
            var number = document.getElementById("memberAmt").value;
            var container = document.getElementById("memberList");
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                var input = document.createElement("input");
                input.type = "text";
                input.name = "members["+(i+1)+"]";
                input.placeholder = "Name";
                container.appendChild(input);
                var input1 = document.createElement("input");
                input1.type = "text";
                input1.name = "instrument["+(i+1)+"]";
                input1.placeholder = "Instrument";
                container.appendChild(input1);
                container.appendChild(document.createElement("br"));
            }
        }
        
        function goBack() {
            window.history.back();
        }
    </script>
  </body>
</html>
