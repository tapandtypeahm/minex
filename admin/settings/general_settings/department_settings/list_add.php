<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print  addBtn">Add a Department</h4>
<?php 
if(isset($_SESSION['ack']['msg']) && isset($_SESSION['ack']['type']))
{
	
	$msg=$_SESSION['ack']['msg'];
	$type=$_SESSION['ack']['type'];
	
	
		if($msg!=null && $msg!="" && $type>0)
		{
?>
<div class="alert no_print  <?php if(isset($type) && $type>0 && $type<4) echo "alert-success"; else echo "alert-error" ?>">
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
<div id="insertDiv">
    <form id="addOurCompanyForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=add'; ?>" method="post" onsubmit="return submitOurCompany()">
    	<table id="insertTable" class="insertTableStyling no_print">
    
        	<tr>

				<td class="firstColumnStyling">
                Department Name<span class="requiredField">* </span> : 
                </td>
                
                <td>
                <input type="text" name="name" id="txtname"/>
                </td>
			</tr>

			<tr>

				<td class="firstColumnStyling">
                Parent Department <span class="requiredField">* </span> : 
                </td>
                
                <td>
                <Select name="parent_id" id="parent_id" >
               	 	<option value="-1">-- Please Select --</option>
                	<option value="0">No Parent</option>
                    <?php $departments=listDepartment();
						foreach($departments as $department)
						{
							
					?>
                    <option value="<?php echo $department['department_id']; ?>"><?php echo $department['department_name']; ?></option>
                    <?php		
							}
					 ?>
                </Select>
                </td>
			</tr>

            <tr>
                <td>
                Description : 
                </td>
                
                <td>
                <textarea name="description" id="transliterateTextarea" cols="5" rows="6"></textarea>
                </td>
            </tr>

           
            <tr>
            <td></td>
            <td>
            <input type="submit" value="Add Department" class="btn btn-warning">
            <a href="<?php echo WEB_ROOT ?>admin/settings/"><input type="button" value="back" class="btn btn-success" /></a>
            </td>
            </tr>
</table>
</form>	
</div>
    <hr class="firstTableFinishing" />

<h4 class="headingAlignment">List of Departments</h4>
    <div class="no_print">
   
    <table id="adminContentTable" class="adminContentTable no_print">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Name</th>
            <th class="heading">Parent</th>
            <th class="heading">Description</th>
              <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		$ourCompanies=listDepartment();
		$i=0;
		foreach($ourCompanies as $ourCompanyDetails)
		{
		 ?>
         <tr class="resultRow">
        	<td><?php echo ++$i; ?></td>
            <td><?php echo $ourCompanyDetails['department_name']; ?>
            </td>
              <td><?php echo getDepartmentNameById($ourCompanyDetails['parent_id']); ?>
            </td>
            <td><?php echo $ourCompanyDetails['description']; ?>
            </td>
             <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$ourCompanyDetails['department_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=edit&lid='.$ourCompanyDetails['department_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
            </td>
            <td class="no_print"> 
            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=delete&lid='.$ourCompanyDetails['department_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
            </td>
            
          
  
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
   <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>