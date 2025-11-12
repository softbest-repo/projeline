<?php 
	ob_start();

	include ('f/conf/config.php');
		
	setcookie("politica".$cookie, 1, time()+86400, "/");					
?>
