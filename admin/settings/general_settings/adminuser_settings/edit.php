<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Edit Admin User</h4>
<?php 
if(!isset($_GET['lid']))
{
	header("Location: index.php");
	exit;
	}
$admin_id=$_GET['lid'];
$admin=getAdminUserByID($admin_id);
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
<form id="addLocForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=edit'; ?>" method="post">
<table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Department<span class="requiredField">* </span> : 
</td>
<td>
<select type="text" name="department_id" id="deparment_id" onchange="createDropDownDesignationDepartment(this.value)" onblur="createDropDownDesignationDepartment(this.value)">
	<option value="-1">-- Please Select --</option>
    <?php $departments=listDepartment();
	foreach($departments as $department)
	{
	?>
    <option value="<?php echo $department['department_id'] ?>" <?php if($department['department_id']==$admin['department_id']) { ?> selected="selected" <?php } ?>><?php echo $department['department_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>

<tr>
<td>
Designation<span class="requiredField">* </span> : 
</td>
<td>
<Select type="text" name="designation_id" id="designation_id">
	<option value="-1">-- Please Select --</option>
    <?php
	$designations=getDesignationsForDepartment($admin['designation_id']);
	foreach($designations as $designation)
	{
	?>
    	<option value="<?php echo $designation['designation_id']; ?>" <?php if($designation['designation_id']==$admin['designation_id']) { ?> selected="selected" <?php } ?>><?php echo $designation['designation_name']; ?></option>
    <?php	
		}
	 ?>
</Select> 
</td>
</tr>

<tr>
<td>
Email : 
</td>
<td>
<input type="hidden" name="lid"  value="<?php echo $admin['admin_id']; ?>"/> 
<input type="text" name="email" id="txtEmail" value="<?php echo $admin['admin_email']; ?>"/> 
</td>
</tr>

<tr>
<td> Name : </td> 
<td><input type="text" name="name" id="txtName" value="<?php echo $admin['admin_name']; ?>"/> </td>
</tr>

<tr>
<td> User Name : </td>
<td><input type="text" disabled="disabled" value="<?php echo $admin['admin_username']; ?>"  />
<input type="hidden" name="username"  value="<?php echo $admin['admin_username']; ?>"/> 
</td> 
</tr>
<?php  $contactNumbers = $admin['contact_no'];
$lj=0;
foreach($contactNumbers as $contact)
{
 ?>
  <tr>
            <td>
            Contact No<?php if($lj==0) { ?><span class="requiredField">* </span> <?php } ?> : 
            </td>
            
            <td id="addcontactTd">
            <input type="text" class="contact" <?php if($lj==0) { ?> id="AdminContact" <?php } ?> name="contact_no[]" <?php if($lj!=0) { ?> onblur="checkContactNo(this.value,this)" <?php } ?> placeholder="more than 6 Digits!" value="<?php echo $contact[0]; ?>" /><span></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
                </td>
            </td>
            </tr>
<?php
$lj++;
 } ?> 
<tr id="addcontactTrAdmin">
                <td>
                Contact No<span class="requiredField">* </span> : 
                </td>
                
                <td id="addcontactTd">
                <input type="text" class="contact" <?php if($lj<1) { ?> id="AdminContact" <?php } ?> name="contact_no[]" placeholder="more than 6 Digits!" <?php if($lj!=0) { ?> onblur="checkContactNo(this.value,this)" <?php } ?> /> <span class="addContactSpan"><input type="button" title="add more contact no" value="+" class="btn btn-success addContactbtnAdmin"/></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
                </td>
            </tr>

<!-- for regenreation purpose Please donot delete -->
            
            <tr id="addcontactTrGeneratedAdmin">
            <td>
            Contact No : 
            </td>
            
            <td id="addcontactTd">
            <input type="text" class="contact" name="contact_no[]" onblur="checkContactNo(this.value,this)" placeholder="more than 6 Digits!" />  <span class="deleteContactSpan"><input type="button" value="-" title="delete this entry"  class="btn btn-danger deleteContactbtn" onclick="deleteContactTr(this)"/></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
                </td>
            </td>
            </tr>
       
       
<!-- end for regenreation purpose -->

<!-- for regenreation purpose Please donot delete -->


<tr>

<td>Access Rights : </td>
<td><?php $admin_rights=getAllAdminRights();
$currentRights=getAdminRightsForAdminId($admin_id);
foreach($admin_rights as $right)
{
	?>
  <input id="<?php echo $right['admin_right_id'] ?>" type="checkbox" name="right[]" value="<?php echo $right['admin_right_id'] ?>" class="insertCheckBox" <?php if($right['admin_right_id']==1) { ?> checked="checked" disabled="disabled" <?php } if(in_array($right['admin_right_id'],$currentRights)) { ?> checked="checked"  <?php } ?> /> <label class="insertCheckBoxLabel" for="<?php echo $right['admin_right_id'] ?>"><?php echo $right['admin_right'] ?></label> 
<?php    
}?></td>
</tr>

<tr>

<td>Report Rights : </td>
<td><?php $admin_rights_report=getAllAdminReportRights();
foreach($admin_rights_report as $right)
{
	?>
  <input id="<?php echo $right['admin_right_id'] ?>" type="checkbox" name="right[]" value="<?php echo $right['admin_right_id'] ?>" class="insertCheckBox" <?php if($right['admin_right_id']==1) { ?> checked="checked" disabled="disabled" <?php } if(in_array($right['admin_right_id'],$currentRights)) { ?> checked="checked"  <?php } ?>  /> <label class="insertCheckBoxLabel" for="<?php echo $right['admin_right_id'] ?>"><?php echo $right['admin_right'] ?></label> 
<?php    
}?></td>
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