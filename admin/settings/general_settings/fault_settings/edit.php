<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit Fault Details</h4>
<?php 
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	exit;
	}
$f_id=$_GET['lid'];


$fault=getFaultNameFromFaultId($f_id);
if(isset($_SESSION['ack']['msg']) && isset($_SESSION['ack']['type']))
{
	
	$msg=$_SESSION['ack']['msg'];
	$type=$_SESSION['ack']['type'];
	
	
		if($msg!=null && $msg!="" && $type>0)
		{
?>
<div class="alert  <?php if(isset($type) && $type>0 && $type<4) echo "alert-success"; else echo "alert-error" ?>">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php if(isset($type)  && $type>0 && $type<4) { ?> <strong>Success!</strong> <?php } else if(isset($type)   && $type>3) { ?> <strong>Warning!</strong> <?php } ?> <?php echo $msg; ?>
</div>
<?php
		
		
		}
	if(isset($type) && $type>0)
		$_SESSION['ack']['type']=0;
	if($msg!="")
		$_SESSION['ack']['msg']=="";
}

?>
<form id="addLocForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=edit'; ?>" method="post">
<table id="insertAdminTable" class="insertTableStyling no_print">


<tr>
<td> Fault Name : </td> 
<td><input type="text" name="f_name" id="txtName" value="<?php echo $fault['fault_name']; ?>"/> 
<input type="hidden" name="lid" value="<?php echo $f_id; ?>"  />
</td>
</tr>


<tr>
<td></td>
<td><input type="submit" value="Edit" class="btn btn-warning">
<a href="index.php"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>
</table>
</form>
</div>
<div class="clearfix"></div>