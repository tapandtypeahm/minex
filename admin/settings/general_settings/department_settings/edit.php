<?php
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	}
$department_id=$_GET['lid'];
$department=getDepartmentById($department_id);

$disjoint_departments=listDisjointDepartment($department_id);
 ?>
<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit Department Details</h4>
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
<form id="addOurCompanyForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=edit'; ?>" method="post" onsubmit="return submitOurCompany()">
<table id="insertTable" class="insertTableStyling no_print">

<tr>

<td class="firstColumnStyling">
Department Name<span class="requiredField">* </span> : 
</td>

<td>
<input type="hidden" name="lid" value="<?php echo $department_id; ?>" />
<input type="text" name="name" id="txtname" value="<?php echo $department['department_name']; ?>"/>
</td>
</tr>

<tr>

				<td class="firstColumnStyling">
                Parent Department <span class="requiredField">* </span> : 
                </td>
                
                <td>
                <Select name="parent_id" id="parent_id" >
               	 	<option value="-1">-- Please Select --</option>
                	<option value="0" <?php if($department['parent_id']==0) { ?> selected="selected" <?php } ?>>No Parent</option>
                    <?php 
						foreach($disjoint_departments as $depart)
						{
							if($depart['department_id']!=$department_id)

{							
					?>
                    <option value="<?php echo $depart['department_id']; ?>" <?php if($department['parent_id']==$depart['department_id']) { ?> selected="selected" <?php } ?>><?php echo $depart['department_name']; ?></option>
                    <?php		
}
}
					 ?>
                </Select>
                </td>
			</tr>

		 <tr>
                <td>
                Description<span class="requiredField">* </span> : 
                </td>
                
                <td>
                <textarea name="description" id="txtaddress" cols="5" rows="6"><?php echo $department['description']; ?></textarea>
                </td>
            </tr>

<tr>
<td></td>
<td>
<input type="submit" value="Edit" class="btn btn-warning">
<a href="index.php"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>
</table>
</form>  
</div>
<div class="clearfix"></div>
<script type="text/javascript">
 $( ".datepicker1" ).datepicker({
      changeMonth: true,
      changeYear: true,
	   dateFormat: 'dd/mm/yy'
    });

</script>