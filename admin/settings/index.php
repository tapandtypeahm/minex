<?php
require_once "../../lib/cg.php";
require_once "../../lib/bd.php";

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

	$content="list.php";
	
$pathLinks=array("Home","Registration Form");
$selectedLink="settings";
require_once "../../inc/template.php";	
 ?>


 