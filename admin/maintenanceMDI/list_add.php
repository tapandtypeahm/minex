<div class="insideCoreContent adminContentWrapper wrapper">




<hr class="firstTableFinishing" />

<h4 class="headingAlignment">Generated MDI Queries</h4>
<div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Machine Name</th>
            <th class="heading">Machine Code</th>
            <th class="heading">Machine Condition</th>
            <th class="heading">Type of Fault</th>
            <th class="heading">Fault Explanation</th>
            <th class="heading">From Department</th>
            <th class="heading">Created By</th>
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
            
            <td><?php echo $form['fault_explanation']; ?>
            </td>
            <td><?php echo getMachineDepartmentFromMachineId($form['machine_id']) ?> </td>
            
            <?php  
			
            $result = getAdminUserByID($form['created_by']);
			?>
            <td> <?php echo $result['admin_name']; ?> </td>
            
            
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$form['mdi_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            
            
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>