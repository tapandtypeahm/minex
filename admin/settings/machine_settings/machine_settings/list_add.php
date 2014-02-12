<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Add a New Machine</h4>
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
<form id="addLocForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=add'; ?>" method="post" onsubmit="insertMachine()">
<table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Department <span class="requiredField">* </span> : 
</td>
<td>
<select type="text" name="department_id" id="department_id" onchange="createDropDownDesignationDepartment(this.value)" onblur="createDropDownDesignationDepartment(this.value)">
	<option value="-1">-- Please Select --</option>
    <?php $departments=listDepartment();
	foreach($departments as $department)
	{
	?>
    <option value="<?php echo $department['department_id'] ?>" ><?php echo $department['department_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>



<tr>
<td> Machine Name<span class="requiredField">* </span> : </td> 
<td><input type="text" name="mName" id="txtName"/> </td>
</tr>

<tr>
<td> Machine Code<span class="requiredField">* </span> : </td>
<td> <input type="text" name="mCode" id="txtCode"/> </td> 
</tr>



<tr>
<td> Description<span class="requiredField"> </span> : </td>
<td> <textarea rows="10" cols="6" name="macDescription" id="macDescription" > </textarea></td> 
</tr>


<tr>
<td></td>
<td><input type="submit" value="Add Machine" class="btn btn-warning">
<a href="<?php echo WEB_ROOT ?>admin/settings/"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>

</table>
</form>

<hr class="firstTableFinishing" />

<h4 class="headingAlignment">List of Machines</h4>
<div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Machine Name</th>
            <th class="heading">Machine Code</th>
            <th class="heading">Department</th>
            <th class="heading">Description</th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		$machines=listMachines();
		
		$no=0;
		foreach($machines as $machine)
		{
		 ?>
         <tr class="resultRow">
        	<td><?php echo ++$no; ?>
            </td>
            <td><?php echo $machine['machine_name']; ?>
            </td>
             <td><?php echo $machine['machine_code']; ?>
            </td>
            <td><?php echo $machine['department_name']; ?>
            </td>
            <td><?php echo $machine['description']; ?>
            </td>
            
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$machine['machine_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=edit&lid='.$machine['machine_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
            </td>
            <td class="no_print"> 
            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=delete&lid='.$machine['machine_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
            </td>
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>