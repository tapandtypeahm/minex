<?php 
if (!defined('WEB_ROOT')) {
	exit;
}
if(isset($_SESSION['minexAdminSession']['admin_id']))
{
	
}
else
{
	header("Location:".WEB_ROOT."login.php");
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Minex-Admin Section</title>
<link rel="stylesheet" href="<?php echo WEB_ROOT ?>css/adminMain.css" />
<link rel="stylesheet" href="<?php echo WEB_ROOT ?>css/table.css" />
<link rel="stylesheet" href="<?php echo WEB_ROOT ?>css/bp.css" />
<link rel="stylesheet" href="<?php echo WEB_ROOT ?>css/TableTools_JUI.css" />
<link rel="stylesheet" href="<?php echo WEB_ROOT ?>css/TableTools.css" />



<?php
if(isset($cssArray)){
 foreach($cssArray as $css){
	?>
   <link rel="stylesheet" href="<?php echo WEB_ROOT."css/".$css; ?>" /> 
<?php
	}} ?>


<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/jsapi"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/tableToCSV.js"></script>

</head>

<body>
<div id="myModal" class="modal fade no_print"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Authentication Required</h4>
      </div>
      <div class="modal-body">
        <p>Please enter your Password, <?php echo  ucwords($_SESSION['minexAdminSession']['admin_name']); ?>!</p>
        	<form action="<?php echo WEB_ROOT ?>lib/checkForDeletion.php" id="confirmDeletionForm" method="post">
        	<input type="password" id="confirmationPassword" name="p" />
            <input type="hidden" id="delLink" name="delLink" value="" />
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" value="confirm" id="confirmDeletionSubmit"  class="btn btn-danger" />
         </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php 
if(isset($crude) && $crude==true)
{
 $departments_without_maintenance=listCrudeDepartmentsIDs();
 if(in_array($_SESSION['minexAdminSession']['department_id'],$departments_without_maintenance)) { 
$un_ack_actions=getUnAcknowledgedActionForCrudeDepartment($_SESSION['minexAdminSession']['department_id']);
$all_actions=getEligibleActionsForCrudeDepartment($_SESSION['minexAdminSession']['department_id']);

if($un_ack_actions!=false && is_array($un_ack_actions) && count($un_ack_actions)>0)
{
	$backdrop=true;
	 ?>
    
<div class="backDrop"></div>  
<?php  foreach($un_ack_actions as $un_ack) { ?> 
 <div class="crudeAction">
 	 <div class="notificationCenter">
       New Notification
   </div>
   <div class="crudeAssign">
    	Assigned To : <?php echo $un_ack['assign_name']; ?>
    </div>
	<div class="crudeDescription">
    	Description : <?php echo $un_ack['description']; ?>
    </div>
    <div class="ok_button_crude">
    <a href="<?php echo WEB_ROOT ?>admin/indexes/workerController.php?action=acknowledge&lid=<?php echo $un_ack['action_id']; ?>"><button class="ok_button btn btn-warning">ok</button></a>
    </div>
</div>
<?php 
updateActionAsOld($un_ack['action_id']);
} ?>
 <?php } } } ?>
	<div id="mainDiv">
		<div id="header" class="no_print">
			<a href="<?php echo WEB_ROOT; ?>"><div id="logo">Minex</div></a>
				<div id="navigation">
            		<div id="nav">
                     <a id="userNameNav" href="#"><?php echo $_SESSION['minexAdminSession']['admin_name']; ?> &#8711; </a> 
                        <div id="userDetailDropDown">
                        	<ul>
                        		<a href="<?php echo WEB_ROOT."lib/adminuser-functions.php?action=logout" ?>"><li>Log Out</li></a>
                                <a href="<?php echo WEB_ROOT."admin/Profile/index.php" ?>"><li>Change Password</li></a>
                            </ul>    
                        </div>
                	</div>
				</div>
                <div class="greeting"></div>
    	</div>
<div id="content">
<div id="navigationSection" class="no_print">
	  <div class="navigationLinks">   
         
         <?php
		 require_once 'navigation.php' ?>      
         </div>  <!-- End of navigationLinks Div -->
          <div class="clearfix"></div>
</div>


<div class="coreContent <?php
if(isset($_SESSION['minexAdminSession']['admin_rights']))
{
	$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];
	}
 if(! (isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(5,$admin_rights) || in_array(7,$admin_rights))) )
			{ ?> no_print <?php } ?>">
<div id="companyTitle"><?php if(isset($showTitle) && $showTitle==false){} else  echo getDepartmentNameById($_SESSION['minexAdminSession']['department_id']);  ?></div>