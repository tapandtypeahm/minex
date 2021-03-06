<?php
require_once "../../lib/cg.php";
require_once "../../lib/common.php";
require_once "../../lib/bd.php";
require_once "../../lib/mdi-functions.php";
require_once "../../lib/machine-functions.php";
require_once "../../lib/fault-functions.php";
require_once "../../lib/adminuser-functions.php";
require_once "../../lib/takeAction-functions.php";
require_once "../../lib/notifyGenerator-functions.php";

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

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
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(3,$admin_rights) || in_array(7,					$admin_rights)))
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
		else
		{	
		$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
		$_SESSION['ack']['type']=5; // 5 for access
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
			}
	}
	if($_GET['action']=='acknowledge')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(2,$admin_rights) || in_array(7,					$admin_rights)))
		{
		$result=AcknowledgeMDI($_GET["lid"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI Acknowledged successfully!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
		else
		{	
		$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
		$_SESSION['ack']['type']=5; // 5 for access
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
			}
		}	
	if($_GET['action']=='delete')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(4,$admin_rights) || in_array(7,					$admin_rights)))
		{
		$result=deleteMDIForm($_GET["lid"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
				
			$_SESSION['ack']['msg']="Invalid Inpur Or Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			else if($result=="error1"){
				
			$_SESSION['ack']['msg']="Cannot Delete MDI!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
		else
		{	
		$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
		$_SESSION['ack']['type']=5; // 5 for access
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
			}
		}
	if($_GET['action']=='edit')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(3,$admin_rights) || in_array(7,					$admin_rights)))
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
		else
		{	
		$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
		$_SESSION['ack']['type']=5; // 5 for access
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
	}
	}
?>

<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="mdi";
$jsArray=array("jquery.validate.js","validators/adminuser.js","dropDown.js","generateContactNoAdmin.js");
require_once "../../inc/template.php";
 ?>