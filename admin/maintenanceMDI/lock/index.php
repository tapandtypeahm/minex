<?php
require_once "../../../lib/cg.php";
require_once "../../../lib/common.php";
require_once "../../../lib/bd.php";
require_once "../../../lib/department-functions.php";
require_once "../../../lib/takeAction-functions.php";
require_once "../../../lib/lock-functions.php";

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
			if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(2,$admin_rights) || in_array(7,$admin_rights)))
		{	
		$result=insertLock($_POST['name'], $_POST['applying'], $_POST['removing'], $_POST['mdi_id']);
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
		else
			{	
			$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
			$_SESSION['ack']['type']=5; // 5 for access
			header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$_POST['mdi_id']);
			exit;
			}
	}
		
	if($_GET['action']=='delete')
	{	
		
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(4,$admin_rights) || in_array(7,$admin_rights)))
		{
		$result=deleteLock($_GET["lid"]);

		if($result=="success")
			{
			$_SESSION['ack']['msg']="Lock deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){	
			$_SESSION['ack']['msg']="Cannot delete Lock!";
			$_SESSION['ack']['type']=4; // 4 for error
			}

		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
		else
			{	
			$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
			$_SESSION['ack']['type']=5; // 5 for access
			header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$_POST['mdi_id']);
			exit;
			}
		}
	if($_GET['action']=='edit')
	{

		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(3,$admin_rights) || in_array(7,$admin_rights)))
		{
		$result=updateLock($_POST['lid'], $_POST["name"], $_POST["applying"], $_POST["removing"], $_POST["mdi_id"]);

		if($result=="success")
			{
			$_SESSION['ack']['msg']="Lock Updated Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
			$_SESSION['ack']['msg']="Cannot Update Lock! Duplicate or Invalid Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		header("Location: ".WEB_ROOT."admin/maintenanceMDI/index.php?view=details&lid=".$_POST['mdi_id']);
		exit;
		}	
		else
			{	
			$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
			$_SESSION['ack']['type']=5; // 5 for access
			header("Location: ".WEB_ROOT.'admin/maintenanceMDI/index.php?view=details&lid='.$_POST['mdi_id']);
			exit;
			}
		}			
	}
?>
<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="mdi";
$jsArray=array("jquery.validate.js","validators/action.js","dropDown.js","cScript.ashx","transliteration.I.js", "datetimepicker.min.js");
$cssArray=array("datetimepicker.min.css");
require_once "../../../inc/template.php";
 ?>
 <script type="text/javascript">
  $(function() {
    $('#datetimepicker3').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>

<script type="text/javascript">
  $(function() {
    $('#datetimepicker4').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>