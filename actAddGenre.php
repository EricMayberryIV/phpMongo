<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script> 
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


<?php
$genreName = $_POST['genreName'];
$genreNotes = $_POST['genreNotes'];

$collection = $db->genre;

$document = array( 
      "genre_name" => $genreName, 
      "genre_notes" => $genreNotes
   );

var_dump($document);
	
$collection->insert($document);
header("location: maintGenre.php");