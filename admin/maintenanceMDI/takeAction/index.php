<?php
require_once "../../../lib/cg.php";
require_once "../../../lib/common.php";
require_once "../../../lib/bd.php";
require_once "../../../lib/department-functions.php";
require_once "../../../lib/takeAction-functions.php";

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

if((in_array(4,$admin_rights) || in_array(7,$admin_rights)))
{}
else
{
	header("Location: ".WEB_ROOT."admin/MDI");
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
		
		$result=insertAction($_POST['assignName'], $_POST['jobDescription'], $_POST['department_id'], $_POST['mdi_id']);
		
		
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action successfully added!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$_POST['mdi_id']);
		exit;
		}
		
	if($_GET['action']=='delete')
	{
		$id = getMdiIdFromActionId($_GET["lid"]);  // To Get the MDI Id for passing into the URL below to redirect
		
		$result=deleteAction($_GET["lid"]);
		
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
				
			$_SESSION['ack']['msg']="Cannot delete Action! Machine already in use!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			
			
		
		header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$id);
		exit;
		}
		
		
	if($_GET['action']=='edit')
	{
		$result=updateAction($_POST['lid'], $_POST["department_id"], $_POST["assignName"], $_POST["jobDescription"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action Updated Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
			$_SESSION['ack']['msg']="Cannot Update Action! Duplicate or Invalid Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$_POST['mdi_id']);
		exit;
		}			
	}
?>

<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="mdi";
$jsArray=array("jquery.validate.js","validators/action.js","dropDown.js","cScript.ashx","transliteration.I.js");
require_once "../../../inc/template.php";
 ?>