<?php 

$mdi_id = $_GET['id'];
if (!checkForNumeric($mdi_id))
{
	exit;
}

$details = listNotifyGeneratorFromMDIId($mdi_id);

?>

<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print"> Complete MDI Form</h4>
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
<form id="addLocForm" 
action="<?php 
if($details==false)
{
	echo 'index.php?action=add';
}
else if($details!= false && checkForNumeric($details['notify_id']))
{
	echo 'index.php?action=edit';
}


 ?>" method="post">
 <?php 
 if($details!= false && checkForNumeric($details['notify_id']))
{
	?>
    <input type="hidden" name="lid" value="<?php echo $details['notify_id']?>" />
	<?php
}
     ?>
<input type="hidden" name="mdi_id" value="<?php echo  $mdi_id; ?>" />
 <table id="insertAdminTable" class="insertTableStyling no_print">

<tr>
<td> Machine Down Mode <span class="requiredField">* </span> : </td> 
<td>
<table><tr><td><input type="radio" name="mode" value="1" <?php if($details!=false) { if($details['machine_down_mode']==1) { ?> checked="checked"<?php  } } else { ?>checked="checked" <?php } ?> id="preventive" onchange="generateOtherDetails()"></td><td><label for="running">Preventive</label></td></tr>
<tr><td>
<input type="radio" name="mode" value="0" <?php if($details!=false) { if($details['machine_down_mode']==0) { ?> checked="checked"<?php  } }  ?> id="idle"></td><td><label for="breakdown" onchange="generateOtherDetails()">Breakdown</label></td></tr></table></td>
</tr>



<tr>
<td> Job starting Date/Time <span class="requiredField">* </span>: </td> 
<td>

  <div id="datetimepicker1" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="starting" 
	
	<?php if($details!=false) 
	{ ?> 
    value= <?php echo '"'.date('d/m/Y H:i:s',strtotime($details['job_started'])).'"';
	}?>
    
    </input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
 
</td>
</tr>

<tr>
<td> Job assigned To <span class="requiredField">* </span> : </td> 
<td><input type="text" name="assignName" id="txtName" 
    <?php if($details!=false) 
	{ ?> 
    value = <?php echo '"'.$details['assigned_to'].'"';}?> /> </td>
</tr>



<tr>
<td> Job Status <span class="requiredField">* </span> : </td> 
<td>
<table><tr><td><input type="radio" name="jobStatus" value="0"  onchange="toggleMDICompletetion(this.value)" <?php if($details!=false) { if($details['mdi_completed']==0) { ?> checked="checked"<?php  } } else { ?>checked="checked" <?php } ?>  id="running"></td><td><label for="running">Running</label></td></tr>
<tr><td>
<input type="radio" name="jobStatus" value="1" id="completed" onchange="toggleMDICompletetion(this.value)" <?php if($details!=false) { if($details['mdi_completed']==1) { ?> checked="checked"<?php  } } ?> ></td><td><label for="completed">Completed</label></td></tr></table></td>
</tr>

</table>

<table id="jobCompletedTable" style="display:none;">
<tr>
<td style="width:195px;"> Job Ending Date/Time <span class="requiredField">* </span> : </td> 
<td>

  <div id="datetimepicker2" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="ending"
    <?php if($details!=false && strtotime($details['job_ended'])>0) 
	{ ?> 
    value= <?php echo '"'.date('d/m/Y H:i:s',strtotime($details['job_ended'])).'"';
	}
	?>
    />
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
  
</td>
</tr>



<tr>
<td> Actual Work Done <span class="requiredField"> * </span> : </td>
<td> <textarea rows="10" cols="6" name="workDone" id="workDone" ><?php if($details!=false){ ?><?php echo $details['work_done'];}?></textarea></td> 
</tr>

</table>



<table>

<tr>
<td style="width:195px;"></td>
<td><input type="submit" value="Update" class="btn btn-warning">
<a href="../index.php?view=details&lid=<?php echo $mdi_id ?>"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>

</table>
</form>





	
     
</div>
<div class="clearfix"></div>
