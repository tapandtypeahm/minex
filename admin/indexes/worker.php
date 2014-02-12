<?php 
require_once("../lib/cg.php");
require_once("../lib/bd.php");
$selectedLink="home";
require_once("../lib/department-functions.php");
require_once("../lib/takeAction-functions.php");
$un_ack_actions=getUnAcknowledgedActionForCrudeDepartment($_SESSION['minexAdminSession']['department_id']);
$all_actions=getEligibleActionsForCrudeDepartment($_SESSION['minexAdminSession']['department_id']);
?>
<h4 class="headingAlignment">All Actions</h4>
<div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">ID</th>
            <th class="heading">Status</th>
            <th class="heading">Assigned To</th>
            <th class="heading">Description</th>
            <th class="heading datetime">Added On</th>
             <th class="heading no_print"></th>
              <th class="heading no_print"></th>
               <th class="heading no_print"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		
		$no=0;
		foreach($all_actions as $action)
		{
		 ?>
         <tr class="resultRow <?php  if(getMDIStatus($action['mdi_id'])=="NEW") echo "dangerRow"; else if(getMDIStatus($action['mdi_id'])=="IN PROGRESS") echo "blueRow"; else if(getMDIStatus($action['mdi_id'])=="ACKNOWLEDGED" || getMDIStatus($action['mdi_id'])=="WAITING FOR APPROVAL" || getMDIStatus($action['mdi_id'])=="FINAL APPROVAL REJECTED") echo "warningRow"; else if(getMDIStatus($action['mdi_id'])=="COMPLETED") echo "shantiRow"  ?>">
        	<td><?php echo ++$no; ?>
            </td>
            <td><?php echo $action['mdi_identifier']; ?>
            </td>
            <td><?php echo getMDIStatus($action['mdi_id']); ?>
            </td>
            <td><?php echo $action['assign_name']; ?>
            </td>
            <td><?php echo $action['description']; ?>
            </td>
            <td><?php echo  date('d/m/Y H:i:s', strtotime($action['date_added'])); ?>
            </td>
            <td class="no_print"> <a href="<?php echo WEB_ROOT.'admin/indexes/workerController.php?action=done&lid='.$action['action_id'] ?>"><button title="View this entry" class="btn btn-success">DONE</button></a>
            </td>
             <td class="no_print"> <a href="<?php echo WEB_ROOT.'admin/indexes/workerController.php?action=help&lid='.$action['action_id'] ?>"><button title="View this entry" class="btn btn-warning">Need Help</button></a>
            </td>
             <td class="no_print"> <a href="<?php echo WEB_ROOT.'admin/indexes/workerController.php?action=notdone&lid='.$action['action_id'] ?>"><button title="View this entry" class="btn btn-danger">NOT DONE</button></a>
            </td>
       
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table>
     <script type="text/javascript">
	setInterval('checkForNewActions(<?php echo $_SESSION['minexAdminSession']['department_id'];  ?>)',1000);
     </script>