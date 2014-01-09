<?php 

$mdi_id = $_GET['id'];
if (!checkForNumeric($mdi_id))
{
	exit;
}

$details = listLockFromMDIId ($mdi_id);
$mdi=getMDIFormDetailsFromMDIId($mdi_id);

?>

<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print"> Add a Lock To <?php echo $mdi['machine_name']." [".$mdi['machine_code']."]";  ?> </h4>
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
else if($details!= false && checkForNumeric($details['lock_id']))
{
	echo 'index.php?action=edit';
}


 ?>" method="post">
 <?php 
 if($details!= false && checkForNumeric($details['lock_id']))
{
	?>
    <input type="hidden" name="lid" value="<?php echo $details['lock_id']?>" />
	<?php
}
     ?>
<input type="hidden" name="mdi_id" value="<?php echo  $mdi_id; ?>" />
 <table id="insertAdminTable" class="insertTableStyling no_print">


<tr>
<td> Lock Applied Date/Time <span class="requiredField">* </span>: </td> 
<td>

  <div id="datetimepicker3" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="applying" 
	
	<?php if($details!=false) 
	{ ?> 
    value= <?php echo '"'.date('d/m/Y H:i:s',strtotime($details['lock_applied'])).'"';
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
<td> Applied By <span class="requiredField">* </span> : </td> 
<td><input type="text" name="name" id="txtName" 
    <?php if($details!=false) 
	{ ?> 
    value = <?php echo '"'.$details['lock_applied'].'"';}?> /> </td>
</tr>

<tr>
<td style="width:195px;"> Lock Removing Date/Time : </td> 
<td>

  <div id="datetimepicker4" class="input-append date">
    <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="removing"
    <?php if($details!=false && strtotime($details['job_removed'])>0) 
	{ ?> 
    value= <?php echo '"'.date('d/m/Y H:i:s',strtotime($details['job_removed'])).'"';
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
<td style="width:195px;"></td>
<td><input type="submit" value="Apply Lock" class="btn btn-warning">
<a href="../index.php?view=details&lid=<?php echo $mdi_id ?>"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>


</form>
</div>
<div class="clearfix"></div>