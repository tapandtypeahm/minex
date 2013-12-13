<?php
require_once('lib/cg.php');
if(isset($_SESSION['minexAdminSession']['admin_id']))
{
		header("Location: ".WEB_ROOT."admin/");
		exit;
	}
else
{
		
		header("Location: ".WEB_ROOT."login.php");
		exit;
	
	}
 ?>