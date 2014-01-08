<?php
require_once "../../../lib/cg.php";
require_once "../../../lib/common.php";
require_once "../../../lib/bd.php";
require_once "../../../lib/notifyGenerator-functions.php";
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
		
		$result=insertNotifyGenerator($_POST['mode'], $_POST['assignName'], $_POST['starting'], $_POST['jobStatus'], $_POST['ending'], $_POST['workDone'],  $_POST['mdi_id']);
		
		
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI successfully updated!";
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
		$result=deleteNotifyGenerator($_GET["lid"]);
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI Form deleted Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
				
			$_SESSION['ack']['msg']="Cannot delete MDI! MDI already in use!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
			
			
		
		header("Location: ".$_SERVER['PHP_SELF']);
		exit;
		}
	if($_GET['action']=='edit')
	{
		
		$result=updateNotifyGenerator($_POST['lid'], $_POST["mode"], $_POST["assignName"], $_POST["starting"], $_POST['jobStatus'], $_POST["ending"], $_POST["mdi_id"], $_POST["workDone"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="MDI Form Updated Successfuly!";
		$_SESSION['ack']['type']=3; // 3 for delete
			}
			else if($result=="error"){
			$_SESSION['ack']['msg']="Cannot Update MDI Form! Duplicate or Invalid Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		header("Location: ".WEB_ROOT.'admin/maintenanceMDI/index.php?view=details&lid='.$_POST['mdi_id']);
		exit;
		}			
	}
?>

<?php

$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="mdi";
$jsArray=array("jquery.validate.js","validators/action.js","dropDown.js","cScript.ashx","transliteration.I.js", "datetimepicker.min.js", "generateOtherDetails.js");
$cssArray=array("datetimepicker.min.css");
require_once "../../../inc/template.php";
 ?>
 <?php if(isset($details) && $details!=false) { if($details['mdi_completed']==1) { ?>
<script type="text/javascript">
toggleMDICompletetion(1);
</script>
<?php  }} ?>
 <script type="text/javascript">
  $(function() {
    $('#datetimepicker1').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>

<script type="text/javascript">
  $(function() {
    $('#datetimepicker2').datetimepicker({
      language: 'pt-BR'
    });
  });
</script>