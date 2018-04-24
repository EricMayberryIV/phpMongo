<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
   // connect to mongodb
   $m = new MongoClient();
	
   // select a database
   $db = $m->recColl;
?>