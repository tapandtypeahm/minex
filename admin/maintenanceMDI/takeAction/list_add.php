<?php 

$mdi_id = $_GET['id'];
if (!checkForNumeric($mdi_id))
{
	exit;
}
?>

<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Take an Action</h4>
<?php 

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
<form id="addLocForm" action="<?php echo 'index.php?action=add'; ?>" method="post">
<input type="hidden" name="mdi_id" value="<?php echo  $mdi_id; ?>" />
 <table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Department <span class="requiredField">* </span> : 
</td>
<td>
<select type="text" name="department_id" id="department_id">
	<option value="-1">-- Please Select --</option>
    <?php $departments=listCrudeDepartments();
	foreach($departments as $department)
	{
	?>
    <option value="<?php echo $department['department_id'] ?>" ><?php echo $department['department_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>



<tr>
<td>  Assign job to (Names) : </td> 
<td><input type="text" name="assignName" id="txtName"/> </td>
</tr>



<tr>
<td> Job Description<span class="requiredField"> * </span> : </td>
<td> <textarea rows="10" cols="6" name="jobDescription" id="transliterateTextarea" > </textarea></td> 
</tr>


<tr>
<td></td>
<td><input type="submit" value="Submit Action" class="btn btn-warning">
<a href="<?php echo WEB_ROOT ?>admin/maintenanceMDI/index.php?view=details&lid=<?php echo $mdi_id?>"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>

</table>
</form>     
</div>
<div class="clearfix"></div>