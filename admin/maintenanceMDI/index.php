<?php
require_once "../../lib/cg.php";
require_once "../../lib/common.php";
require_once "../../lib/bd.php";
require_once "../../lib/MDI-functions.php";
require_once "../../lib/machine-functions.php";
require_once "../../lib/fault-functions.php";
require_once "../../lib/adminuser-functions.php";

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

if((in_array(4,$admin_rights) || in_array(7,$admin_rights)))
{}
else
{
	header("Location: ".WEB_ROOT."admin/settings");
	exit;
	}

if(isset($_GET['view']))
{
	if($_GET['view']=='add')
	{
		$content="list_add.php";
	}
	else if($_GET['view']=='details')
	{
		$content="details.php";
		}
	else if($_GET['view']=='edit')
	{
		$content="edit.php";
		}
	else
	{
		$content="list_add.php";
	}	
}
else
{
		$content="list_add.php";
}		
if(isset($_GET['action']))
{
	if($_GET['action']=='add')
	{
		$result=insertMDI($_POST["condition"], $_POST["faultExplanation"], $_POST["fault_id"],  $_POST['machine_id']);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI Form successfully added!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
	if($_GET['action']=='delete')
	{
		$result=deleteMDIForm($_GET["lid"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Machine deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
				
			$_SESSION['ack']['msg']="Invalid Inpur Or Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			else if($result=="error1"){
				
			$_SESSION['ack']['msg']="Cannot Delete Machine! Minimum One Machine is Required!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
	if($_GET['action']=='edit')
	{
		$result=updateMDIForm($_POST['lid'], $_POST["condition"], $_POST["faultExplanation"], $_POST["fault_id"], $_POST["machine_id"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Machine Updated Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
			$_SESSION['ack']['msg']="Cannot Update Machine!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}			
	}
?>

<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="mdi";
$jsArray=array("jquery.validate.js","validators/adminuser.js","dropDown.js","generateContactNoAdmin.js");
require_once "../../inc/template.php";
 ?>