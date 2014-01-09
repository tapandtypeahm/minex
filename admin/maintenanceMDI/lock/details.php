<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Machine Details</h4>
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
<?php echo $machine['machine_name']; ?>
</td>
</tr>

<tr>
<td> Machine Code : </td> 
<td><?php echo $machine['machine_code']; ?> </td>
</tr>

<tr >
<td width="200px">
Department : 
</td>
<td>
 <?php echo $machine['department_name']; ?>
</td>
</tr>

<tr>
<td> Description : </td>
<td> 
<?php 


if(validateForNull($machine['description']))
{
	echo $machine['description'];
}
else
echo "No Description Available!";
?>
</td> 
</tr>

<tr>
<td> Created By : </td>
<td> <?php echo $machine['admin_name']; ?></td> 
</tr>

<tr>
<td> Last Modified By : </td>
<td> <?php echo $machine['admin_name']; ?></td> 
</tr>

<tr>
<td> Date Added: </td>
<td> <?php echo $machine['date_added']; ?></td> 
</tr>

<tr>
<td> Date Modified : </td>
<td> <?php echo $machine['date_modified']; ?></td> 
</tr>

<tr>
<td> Created From IP : </td>
<td> <?php echo $machine['ip_created']; ?></td> 
</tr>

<tr>
<td> Last Modified From IP : </td>
<td> <?php echo $machine['ip_modified']; ?></td> 
</tr>
     
     


<tr class="no_print">
<td></td>
<td>
<a href="<?php echo $_SERVER['../takeAction - Copy/PHP_SELF'].'?view=edit&lid='.$machine['machine_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
<a href="<?php echo $_SERVER['../takeAction - Copy/PHP_SELF'].'?action=delete&lid='.$machine['machine_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
<a href="../takeAction - Copy/index.php"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>
</table>
</div>
<div class="clearfix"></div>