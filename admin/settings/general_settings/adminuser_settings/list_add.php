<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Add a New Admin User</h4>
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
<form id="addLocForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=add'; ?>" method="post">
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
    <option value="<?php echo $department['department_id'] ?>"><?php echo $department['department_name']; ?></option>
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
</Select> 
</td>
</tr>

<tr>
<td>
Email<span class="requiredField">* </span> : 
</td>
<td>
<input type="text" name="email" id="txtEmail"/> 
</td>
</tr>

<tr>
<td> Name<span class="requiredField">* </span> : </td> 
<td><input type="text" name="name" id="txtName"/> </td>
</tr>

<tr>
<td> User Name<span class="requiredField">* </span> : </td>
<td> <input type="text" name="username" id="txtUsername"/> </td> 
</tr>

<tr>

<td> Password<span class="requiredField">* </span> : </td>
<td> <input type="password" name="password" id="txtPassword"/> </td>
</tr>

<tr>

<tr>

<td>Confirm Password<span class="requiredField">* </span> : </td>
<td> <input type="password" id="txtConfirmPassword"/> </td>
</tr>

<tr id="addcontactTrAdmin">
                <td>
                Contact No<span class="requiredField">* </span> : 
                </td>
                
                <td id="addcontactTd">
                <input type="text" class="contact" id="AdminContact" name="contact_no[]" placeholder="more than 6 Digits!" onblur="checkContactNo(this.value,this)"/> <span class="addContactSpan"><input type="button" title="add more contact no" value="+" class="btn btn-success addContactbtnAdmin"/></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
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
foreach($admin_rights as $right)
{
	?>
  <input id="<?php echo $right['admin_right_id'] ?>" type="checkbox" name="right[]" value="<?php echo $right['admin_right_id'] ?>" class="insertCheckBox" <?php if($right['admin_right_id']==1) { ?> checked="checked" disabled="disabled" <?php } ?> /> <label class="insertCheckBoxLabel" for="<?php echo $right['admin_right_id'] ?>"><?php echo $right['admin_right'] ?></label> 
<?php    
}?></td>
</tr>

<tr>

<td>Report Rights : </td>
<td><?php $admin_rights_report=getAllAdminReportRights();
foreach($admin_rights_report as $right)
{
	?>
  <input id="<?php echo $right['admin_right_id'] ?>" type="checkbox" name="right[]" value="<?php echo $right['admin_right_id'] ?>" class="insertCheckBox" <?php if($right['admin_right_id']==1) { ?> checked="checked" disabled="disabled" <?php } ?> /> <label class="insertCheckBoxLabel" for="<?php echo $right['admin_right_id'] ?>"><?php echo $right['admin_right'] ?></label> 
<?php    
}?></td>
</tr>

<tr>
<td></td>
<td><input type="submit" value="Add Admin User" class="btn btn-warning">
<a href="<?php echo WEB_ROOT ?>admin/settings/"><input type="button" value="back" class="btn btn-success" /></a>
</td>

</tr>
</table>
</form>

<hr class="firstTableFinishing" />

<h4 class="headingAlignment">List of Registered Users</h4>
<div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Email</th>
            <th class="heading">Name</th>
            <th class="heading">Username</th>
            <th class="heading">Rights</th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		$admins=listAdminUsers();
		$no=0;
		foreach($admins as $admin)
		{
		 ?>
         <tr class="resultRow">
        	<td><?php echo ++$no; ?>
            </td>
            <td><?php echo $admin['admin_email']; ?>
            </td>
             <td><?php echo $admin['admin_name']; ?>
            </td>
            <td><?php echo $admin['admin_username']; ?>
            </td>
            <td><?php $rights=getAdminRightsDetailsForAdminId($admin['admin_id']);
						for($i=0;$i<count($rights);$i++)
						{
							$right=$rights[$i];
							if($i==(count($rights)-1))
							echo $right['admin_right'];
							else
							echo $right['admin_right']." | ";
							}
						 ?>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$admin['admin_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=edit&lid='.$admin['admin_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
            </td>
            <td class="no_print"> 
            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=delete&lid='.$admin['admin_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
            </td>
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>