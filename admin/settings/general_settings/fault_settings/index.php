<?php
require_once "../../../../lib/cg.php";
require_once "../../../../lib/common.php";
require_once "../../../../lib/bd.php";
require_once "../../../../lib/fault-functions.php";

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
		$result=insertFault(($_POST['fName']));
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Fault successfully added!";
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
		$result=deleteFault(($_GET["lid"]));
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Fault deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
				
			$_SESSION['ack']['msg']="Cannot delete Fault! Fault already in use!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			else if($result=="error1"){
				
			$_SESSION['ack']['msg']="Cannot Delete Fault! Minimum One Fault is Required!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
	if($_GET['action']=='edit')
	{
		$result=updateFault($_POST['lid'], $_POST["f_name"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Fault Updated Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
			$_SESSION['ack']['msg']="Cannot Update Fault! Duplicate Entry or Invalid Input!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		header("Location: ".'index.php?view=details&lid='.$_POST['lid']);
		exit;
		}			
	}
?>

<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="settings";
$jsArray=array("jquery.validate.js","validators/faults.js","dropDown.js","generateContactNoAdmin.js");
require_once "../../../../inc/template.php";
 ?>