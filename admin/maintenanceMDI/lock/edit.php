<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit Machine Details</h4>
<?php 
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	exit;
	}
$m_id=$_GET['lid'];
$machine=GetMachineDetailsFromMachineId($m_id);
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
<form id="addLocForm" action="<?php echo $_SERVER['../takeAction - Copy/PHP_SELF'].'?action=edit'; ?>" method="post">
<table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Department<span class="requiredField">* </span> : 
</td>
<td>
<input type="hidden" name="lid" value="<?php echo $m_id; ?>" />
<select type="text" name="department_id" id="deparment_id">
	<option value="-1">-- Please Select --</option>
    <?php $departments=listDepartment();
	foreach($departments as $department)
	{
	?>
    <option value="<?php echo $department['department_id'] ?>" <?php if($department['department_id']==$machine['department_id']) { ?> selected="selected" <?php } ?>> <?php echo $department['department_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>



<tr>
<td> Machine Name : </td> 
<td><input type="text" name="name" id="txtName" value="<?php echo $machine['machine_name']; ?>"/> </td>
</tr>

<tr>
<td> Machine Code: </td> 
<td><input type="text" name="code" id="txtName" value="<?php echo $machine['machine_code']; ?>"/> </td>
</tr>


<tr>
<td> Description : </td> 
<td>
<textarea name="description" id="txtName" rows="10" cols="5"><?php echo $machine['description']; ?></textarea>
</td>
</tr>









<tr>
<td></td>
<td><input type="submit" value="Edit" class="btn btn-warning">
<a href="../takeAction - Copy/index.php"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>
</table>
</form>
</div>
<div class="clearfix"></div>