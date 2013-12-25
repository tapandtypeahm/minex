<div class="insideCoreContent adminContentWrapper wrapper">
<a href="index.php"><input type="button" value="Acknowledge" class="btn btn-success" /></a>
<a href="index.php"><input type="button" value="Take Action" class="btn btn-success" /></a>
<h4 class="headingAlignment no_print">MDI Form Details</h4>
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
<div class="alert no_print <?php if(isset($type) && $type>0 && $type<4) echo "alert-success"; else echo "alert-error" ?>">
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


<table id="DetailsTable" class="insertTableStyling">




<tr>
<td>
Machine Name : 
</td>
<td>
<?php echo $mdi['machine_name']; ?>
</td>
</tr>

<tr>
<td> Machine Code : </td> 
<td><?php echo $mdi['machine_code']; ?> </td>
</tr>

<tr >
<td width="200px">
Machine Condition : 
</td>
<td>
 <?php
			     if($form['mdi_condition'] == 0)
				 {
					 echo "Idle";
				 }
				 else
				 {
					echo "Running"; 
					 
				}
			 
			 
 ?>
</td>
</tr>

<tr>
<td> Type of Fault : </td>
<td> <?php echo $mdi['fault_name']; ?></td> 
</tr>

<tr>
<td> Fault Description: </td>
<td> <?php echo $mdi['fault_explanation']; ?></td> 
</tr>

<tr>
<td> Created By : </td>
<td> <?php echo $mdi['admin_name']; ?></td> 
</tr>

<tr>
<td> Last Modified By : </td>
<td> <?php echo $mdi['admin_name']; ?></td> 
</tr>

<tr>
<td> Date Added: </td>
<td> <?php echo date("d/m/Y H:i:s",strtotime($mdi['date_added'])); ?></td> 
</tr>

<tr>
<td> Date Modified : </td>
<td> <?php echo date("d/m/Y H:i:s", strtotime($mdi['date_modified'])); ?></td> 
</tr>


     
     


<tr class="no_print">
<td></td>
<td>

<a href="index.php"><input type="button" value="back" class="btn btn-success" /></a>

</td>
</tr>
</table>
</div>
<div class="clearfix"></div>