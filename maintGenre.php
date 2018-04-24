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

    <title>Music Genres</title>

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
      <h1 class="mt-5">Music Genres</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addModal">
          Add
        </button><br/><br/>
        <table id="companies" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Genre</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $collection = $db->genre;
                $cursor = $collection->find();
                foreach ($cursor as $document) {
                    $id_temp = $document["_id"];
                    $id = substr($id_temp, 0,8);
                  echo "<tr><td>" . $id . "</td>
                            <td>" . $document["genre_name"] . "</td>
                            <td>" . $document["genre_notes"] . "</td></tr>";
               }
                ?>
            </tbody>
        </table>
        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Genre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form class="form-signin" action="actAddGenre.php" method="post">
                      <label for="inputGenreName">Genre</label>
                      <input type="text" name="genreName" id="inputGenreName" class="form-control" required>
                      <br/>
                      <label for="inputGenreDesc">Notes</label>
                      <input type="text" name="genreNotes" id="inputGenreDesc" class="form-control">
                      <br/>
                      <div class="btn-group float-right" role="group">
                          <button class="btn btn-outline-primary" type="reset">Reset</button>
                          <button class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                          <button class="btn btn-outline-success" type="submit">Add</button>
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
                "order": [[ 1, "asc" ]],
                responsive: {
                    details: true
                } 
            });
        } );
    </script>
    
  </body>
</html>





<script>
function goBack() {
    window.history.back();
}
</script>