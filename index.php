<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

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

    <title>Record Collection</title>

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

<?php include 'header.php'; ?>

    <!-- Begin page content -->
    <main role="main" class="container">
      <h1 class="mt-5">Records</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addModal">
          Add
        </button><br/><br/>
        <table id="companies" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Genre</th>
                    <th>Label</th>
                    <th>Year</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
               $collection = $db->vinyl;
               $cursor = $collection->find();
               foreach ($cursor as $document) {
                   $id_temp = $document["_id"];
                   echo "<tr>";
                   if ($document["img_url"] != ''){
                       echo "<td class='text-center'><a href='info.php?id=$id_temp'><img src='" . 
                           $document["img_url"] . 
                           "' height='60' width='60'></a></td>";
                   } else {
                       echo "<td class='text-center'><a href='info.php?id=$id_temp'><img src='uploads/placeholder.svg' height='60' width='60'></a></td>";
                   }
                  echo     "<td>" . $document["title"] . "</td>
                           <td>" . $document["artist"] . "</td>
                           <td>" . $document["genre"] . "</td>
                           <td>" . $document["label"] . "</td>
                           <td>" . $document["year"] . "</td>
                           <td class='text-center'>
                                    <a href='DeleteRecord.php?id=$id_temp'>
                                        <div style='color:Tomato'>
                                          <i class='fas fa-trash-alt'></i>
                                        </div>
                                    </a>
                                </td>
                            </tr>";
              }
                ?>
            </tbody>
        </table>
        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form enctype="multipart/form-data" class="form-signin" action="actAddRecord.php" method="post">
                      <input type="file" name="fileToUpload" id="fileToUpload">
                      <br/>
                      <label for="inputTitle">Title</label>
                      <input type="text" name="title" id="inputTitle" class="form-control" required>
                      <br/>
                      <label for="inputArtist">Artist</label>
                      <input type="text" name="artist" id="inputArtist" class="form-control" required>
                      <br/>
                      <label for="inputGenre">Genre</label>
                      <select class="form-control" name="genre" id="inputGenre">
                          <?php
                          $collGenre = $db->genre;
                          $cursor = $collGenre->find();
                          $cursor->sort(array('genre_name' => 1));
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
                      <select class="form-control" name="year" id="inputYear">
                          <?php
                          
                          for ($i = 1940; $i <= 2050; $i++) {
                              if($i===$thisYear){
                                  echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                              }
                               else {
                                   echo '<option value="' . $i . '">' . $i . '</option>';
                               }
                                  
                                  
                          }
                          ?>
                      </select>
                      <br/>
                      <label for="inputLabel">Label</label>
                      <select class="form-control" name="label" id="inputLabel">
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
                      <input type="text" id="trackAmt" value="" onchange="addFields()" placeholder="# of Tracks">
                      <br />
                      <div id="trackList">
                      </div>
                      <br/>
                      <label for="memberAmt">Members</label>
                      <input type="text" id="memberAmt" name="memberAmt" value="" onchange="addFieldsMember()" placeholder="# of Members">
                      <br />
                      <div id="memberList">
                      </div>
                      <br/>
                      <label for="inputSize">Size</label>
                      <select class="form-control" name="speed" id="inputSpeed">
                          <option value="7">7"</option>
                          <option value="10">10"</option>
                          <option value="12" selected="selected">12"</option>
                      </select>
                      <br/>
                      <label for="inputSpeed">Speed</label>
                      <select class="form-control" name="speed" id="inputSpeed">
                          <option value="33" selected="selected">33</option>
                          <option value="45">45</option>
                          <option value="78">78</option>
                      </select>
                      <br/>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value=true id="input180" name="180">
                        <label class="form-check-label" for="input180">
                          180g
                        </label>
                      </div>
                      <div class="btn-group float-right" role="group">
                          <button class="btn btn-outline-primary" type="reset">Reset</button>
                          <button class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                          <button class="btn btn-outline-success" type="submit" name="submit">Add</button>
                      </div>
                  </form>
              </div>
              
            </div>
          </div>
        </div>
        <p id="delete"></p>
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form class="form-signin" action="actAddCo.php" method="post">
                      <h4>Are you sure you want to delete XXXX?</h4>
                      <br/>
                      <div class="btn-group float-right" role="group">
                          <button class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                          <button class="btn btn-outline-danger" type="submit">Delete</button>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/b-print-1.5.1/r-2.2.1/datatables.min.js"></script>
      
    <script>
        $(document).ready( function () {
            $('#companies').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5','pdf'
                ],
                "order": [[ 2, "asc" ],[5, "asc"]],
                "responsive": true
            });
        } );
        
        function addFields(){
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
                input.name = "member["+(i+1)+"]";
                input.placeholder = "Name";
                container.appendChild(input);
                //container.appendChild(document.createElement("br"));
                var input1 = document.createElement("input");
                input1.type = "text";
                input1.name = "instrument["+(i+1)+"]";
                input1.placeholder = "Instrument";
                container.appendChild(input1);
                container.appendChild(document.createElement("br"));
            }
        }
        
        
      </script>
    
  </body>
</html>





<script>
function goBack() {
    window.history.back();
}
</script>