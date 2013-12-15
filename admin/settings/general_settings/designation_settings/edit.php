<?php
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	}
$department_id=$_GET['lid'];
$designation=getdesignationByID($department_id);
 ?>
<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit Designation Details</h4>
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

<table id="insertTable" class="insertTableStyling no_print">
    
      <tr >
<td>
Department<span class="requiredField">* </span> : 
</td>
<td>
<select type="text" disabled="disabled" id="department_id" onchange="createDropDownDesignationDepartment(this.value)" onblur="createDropDownDesignationDepartment(this.value)">
	<option value="-1">-- Please Select --</option>
    <?php $departments=listDepartment();
	foreach($departments as $department)
	{
	?>
    <option value="<?php echo $department['department_id'] ?>" <?php if($department['department_id']==$designation['department_id']) { ?> selected="selected" <?php } ?>><?php echo $department['department_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
<input type="hidden" name="department_id" value="<?php echo $designation['department_id']; ?>" />
<input type="hidden" name="lid" value="<?php echo $designation['designation_id']; ?>"/>
</td>
</tr>
        
			<tr>

				<td class="firstColumnStyling">
                Successor Designation <span class="requiredField">* </span> : 
                </td>
                
                <td>
                <Select disabled="disabled" id="parent_id" >
               	 	<option value="-1">-- Please Select --</option>
                	<option value="0">No Parent</option>
                    <?php $departments=listDesignations();
						foreach($departments as $department)
						{
							
					?>
                    <option value="<?php echo $department['designation_id']; ?>" <?php if($department['designation_id']==$designation['parent_id']) { ?> selected="selected" <?php } ?>><?php echo $department['designation_name']; ?></option>
                    <?php		
							}
					 ?>
                </Select>
                <input type="hidden" name="parent_id" value="<?php echo $designation['parent_id']; ?>"/>
                </td>
			</tr>
            
            	<tr>

				<td class="firstColumnStyling">
                Designation Name<span class="requiredField">* </span> : 
                </td>
                
                <td>
                <input type="text" name="name" id="txtname" value="<?php echo $designation['designation_name']; ?>"/>
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