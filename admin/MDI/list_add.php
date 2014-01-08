<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment no_print">Fill up the MDI Form </h4>
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
<form id="addLocForm" action="<?php echo WEB_ROOT.'admin/MDI/index.php?action=add'; ?>" method="post" onsubmit="insertMDI()">
<table id="insertAdminTable" class="insertTableStyling no_print">

<tr >
<td width="200px">
Problematic Machine <span class="requiredField">* </span> : 
</td>
<td>
<select type="text" name="machine_id" id="machine_id">
	<option value="-1">-- Please Select --</option>
    <?php 
	
	$machines=listMachines();
	
	foreach($machines as $machine)
	{
	?>
    <option value="<?php echo $machine['machine_id'] ?>" ><?php echo $machine['machine_name']." - ".$machine['machine_code']; ?></option>
    <?php 	
		
		}
	 ?>
</select> 
</td>
</tr>



<tr>
<td> Machine Condition<span class="requiredField">* </span> : </td> 
<td>
<table><tr><td><input type="radio" name="condition" value="1" checked="checked" id="running"></td><td><label for="running">Running</label></td></tr>
<tr><td>
<input type="radio" name="condition" value="0" id="idle"></td><td><label for="idle">Idle</label></td></tr></table></td>
</tr>

<tr>
<td> Type of Fault <span class="requiredField">* </span> : </td>
<td> 
<select type="text" name="fault_id" id="fault_id">
	<option value="-1">-- Please Select --</option>
    <?php $faults=listFaults();
	foreach($faults as $fault)
	{
	?>
    <option value="<?php echo $fault['fault_id'] ?>" ><?php echo $fault['fault_name']; ?></option>
    <?php 	
		
		}
	 ?>
</select>
 </td> 
</tr>



<tr>
<td> Fault Explanation : </td>
<td> <textarea rows="10" cols="6" name="faultExplanation" id="faultExplanation" > </textarea></td> 
</tr>


<tr>
<td></td>
<td><input type="submit" value="Submit" class="btn btn-warning">

</td>
</tr>

</table>
</form>

<hr class="firstTableFinishing" />

<h4 class="headingAlignment">Recently submitted MDI Forms</h4>
<div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Date/Time</th>
            <th class="heading">Machine Name</th>
            <th class="heading">Machine Code</th>
            <th class="heading">Machine Condition</th>
            <th class="heading">Type of Fault</th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
            <th class="heading no_print btnCol"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		$forms=listMDIForm();
		
		$no=0;
		foreach($forms as $form)
		{
		 ?>
         <tr class="resultRow">
        	<td><?php echo ++$no; ?>
            </td>
            <td><?php echo  date('d/m/Y H:i:s', strtotime($form['date_added'])); ?>
            </td>
            
            <td><?php echo $form['machine_name']; ?>
            </td>
             <td><?php echo $form['machine_code']; ?>
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
            <td><?php echo $form['fault_name']; ?>
            </td>
            
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$form['mdi_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=edit&lid='.$form['mdi_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
            </td>
            <td class="no_print"> 
            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=delete&lid='.$form['mdi_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
            </td>
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>
