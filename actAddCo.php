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


<button onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script> 
<?php
$coName = $_POST['coName'];
$coDesc = $_POST['coDesc'];

$collection = $db->company;

$document = array( 
      "co_name" => $coName, 
      "co_description" => $coDesc
   );

var_dump($document);
	
$collection->insert($document);
header("location: maintComp.php");