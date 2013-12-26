<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit MDI Form Details</h4>
<?php 
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	exit;
	}
$m_id=$_GET['lid'];
$mdi=getMDIFormDetailsFromMDIId($m_id);
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
<form id="addLocForm" action="<?php echo 'index.php?action=edit'; ?>" method="post">
<table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Problematic Machine<span class="requiredField">* </span> : 
</td>
<td>
<input type="hidden" name="lid" value="<?php echo $m_id; ?>" />
<select type="text" name="machine_id" id="machine_id">
	<option value="-1">-- Please Select --</option>
    <?php 
	
	$machines=listMachines();
	
	foreach($machines as $machine)
	{
	?>
    <option value="<?php echo $machine['machine_id'] ?>" <?php if($machine['machine_id']==$mdi['machine_id']) { ?> selected="selected" <?php } ?>> <?php echo $machine['machine_name']." - ".$machine['machine_code']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>







<tr>
<td> Machine Condition<span class="requiredField">* </span> : </td> 
<td>
<table><tr><td><input type="radio" name="condition"  <?php if($mdi['mdi_condition']==1) { ?> checked="checked" <?php } ?> value="1"  id="running"></td><td><label for="running">Running</label></td></tr>
<tr><td>
<input type="radio" name="condition" <?php if($mdi['mdi_condition']==0) { ?> checked="checked" <?php } ?> value="0" id="idle"></td><td><label for="idle">Idle</label></td></tr></table></td>
</tr>


<tr>
<td> Type of Fault <span class="requiredField">* </span> : </td>
<td> 
<select type="text" name="fault_id" id="fault_id">
	<option value="-1">-- Please Select --</option>
    <?php $faults=listFaults();
	foreach($faults as $fault)
	{
	?>
    <option value="<?php echo $fault['fault_id'] ?>" <?php if($fault['fault_id']==$mdi['fault_id']) { ?> selected="selected" <?php } ?>><?php echo $fault['fault_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select>
 </td> 
</tr>


<tr>
<td> Fault Explanation : </td> 
<td><textarea name="faultExplanation" id="faultExplanation"  rows="10" cols="6" ><?php echo $mdi['fault_explanation']; ?></textarea> </td>
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