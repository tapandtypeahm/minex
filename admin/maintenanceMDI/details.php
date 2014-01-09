<?php 
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	exit;
	}
$m_id=$_GET['lid'];
$mdi=getMDIFormDetailsFromMDIId($m_id);
$actions = getAllActionForMDIID($m_id);
$statusUpdate=listNotifyGeneratorFromMDIId($m_id);
$lockDetails = listLockFromMDIId($m_id);




?>


<div class="insideCoreContent adminContentWrapper wrapper">
<div class="addDetailsBtnStyling no_print">
<?php if($mdi['acknowledged']!=1) { ?><a href="index.php?action=acknowledge&lid=<?php echo $m_id; ?>"><input type="button" value="Acknowledge" class="btn btn-success" /></a>
<?php } ?>
<a href="takeAction/index.php?id=<?php echo $m_id ?>"><input type="button" value="Take Action" class="btn btn-warning" /></a>
<a href="notifyGenerator/index.php?id=<?php echo $m_id ?>"><input type="button" value="Update MDI Status" class="btn btn-warning" /></a>
<a href="lock/index.php?id=<?php echo $m_id ?>"><input type="button" value="Apply Lock on Machine" class="btn btn-warning" /></a>

<a href="index.php"><input type="button" value="back" class="btn btn-success" /></a></div>

<?php 

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

<div class="detailStyling">

<h4 class="headingAlignment">MDI Form Details [ Reporting Dept.]</h4>
<table class="insertTableStyling detailStylingTable">

<tr>
<td>
MDI Status : 
</td>
<td>
<?php echo getMDIStatus($m_id); ?>
</td>
</tr>

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
<td> 
<?php


 $explanation =$mdi['fault_explanation']; 
 if(!validateForNull($explanation))
 {
	echo "No Explanation Available!"; 
 }
 else
 echo $explanation;
 
 ?>
 
 </td>  
</tr>

<tr>
<td> Created By : </td>
<td> <?php echo $mdi['admin_name']; ?></td> 
</tr>



<tr>
<td> Date Added: </td>
<td> <?php echo date("d/m/Y H:i:s",strtotime($mdi['date_added'])); ?></td> 
</tr>

<!--<tr>
<td> Date Modified : </td>
<td> <?php echo date("d/m/Y H:i:s", strtotime($mdi['date_modified'])); ?></td> 
</tr>-->

</table>

<?php

if(validateForNull($statusUpdate))
{

?>
<h4 class="headingAlignment"> MDI Status Update [ Maintenance Dept.]</h4>
<table class="insertTableStyling detailStylingTable">

<tr>
<td> Machine Down Mode : </td>
<td> 
      <?php 
       if($statusUpdate['machine_down_mode'] == 0)
	   {
		 echo "breakdown";  
	   }
	   else
	   {
		  echo "preventive"; 
	   }
	   ?>
</td> 
</tr>

<tr>
<td> Job starting Time : </td>
<td> <?php echo date("d/m/Y H:i:s", strtotime($statusUpdate['job_started'])); ?></td> 
</tr>

<tr>
<td> Job Assigned To : </td>
<td> <?php echo $statusUpdate['assigned_to']; ?></td> 
</tr>

<tr>
<td> Job Ending Time: </td>
<td> 
<?php 
if (strtotime($statusUpdate['job_ended']) <= 0)
{
	echo "Yet to be added!";
 
}
else
{
	
	echo date("d/m/Y H:i:s", strtotime($statusUpdate['job_ended']));
}
?>

</td> 
</tr>

<tr>
<td> Actual Work Done : </td>
<td> 
<?php 
if(validateForNull($statusUpdate['work_done']) && $statusUpdate['work_done']!="")
{
echo $statusUpdate['work_done']; 
}
else
{
	echo "Yet to be added!";
}

?>
</td> 
</tr>


     
     


<tr class="no_print">
<td></td>
<td>


</td>
</tr>
</table>

<?php
}
?>

<!-- Lock Display details -->

<?php

if(validateForNull($lockDetails))
{

?>
<h4 class="headingAlignment"> Machine Lock Details </h4>
<table class="insertTableStyling detailStylingTable">



<tr>
<td>   Lock Applied Date/Time : </td>
<td> <?php echo date("d/m/Y H:i:s", strtotime($lockDetails['lock_applied'])); ?></td> 
</tr>

<tr>
<td> Lock Applied By : </td>
<td> <?php echo $lockDetails['lock_by']; ?></td> 
</tr>

<tr>
<td> Lock Removing Date/Time: </td>
<td> 
<?php 
if (strtotime($lockDetails['lock_removed']) <= 0)
{
	echo "Yet to be added!";
 
}
else
{
	
	echo date("d/m/Y H:i:s", strtotime($lockDetails['lock_removed']));
}
?>

</td> 
</tr>

<tr class="no_print">
<td></td>
<td>


</td>
</tr>
</table>

<?php
}
?>

<!-- LOCK END -->

</div>

<?php
if(!validateForNull($actions))
{
}
else
{ 
$i=1;
foreach($actions as $action) { ?>
<div class="detailStyling">
<h4 class="headingAlignment no_print">

Action <?php echo $i++;  ?> [<?php echo date("d/m/Y H:i:s",strtotime($action['date_added'])); ?>]


</h4>
<table  class="insertTableStyling detailStylingTable">




<tr>
<td> Department : </td> 
<td><?php echo $action['department_name']; ?> </td>
</tr>


<tr>
<td> Assigned To (Names): </td>
<td> <?php echo $action['assign_name']; ?></td> 
</tr>

<tr>
<td> Job Description: </td>
<td> <?php echo $action['description']; ?></td> 
</tr>

<tr>
<td> Action Taken By : </td>
<td> 
<?php  
$adminId = $action['created_by'];

$adminNameArray = getAdminUserByID($adminId);
$adminName = $adminNameArray['admin_name'];
echo $adminName; 
?>
</td> 
</tr>

<tr class="no_print">
<td></td>
<td>


</td>
</tr>
</table>

</div>
<?php } } ?>




</div>
<div class="clearfix"></div>