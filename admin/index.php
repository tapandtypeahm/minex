<?php
require_once("../lib/cg.php");
require_once("../lib/bd.php");
$selectedLink="home";
require_once("../lib/department-functions.php");
require_once("../lib/takeAction-functions.php");

$departments_without_maintenance=listCrudeDepartmentsIDs();
 if(in_array($_SESSION['minexAdminSession']['department_id'],$departments_without_maintenance))
  { 
 $crude=true; // used in header to display the unack crude actions
 }
require_once("../inc/header.php");
?>
<div class="insideCoreContent adminContentWrapper wrapper"> 
 <div class="widgetContainer">
 
   <div class="notificationCenter">
       Notification Center
   </div>
   <?php   
   $departments_without_maintenance=listCrudeDepartmentsIDs();

     if(in_array($_SESSION['minexAdminSession']['department_id'],$departments_without_maintenance))
  { 
    require_once("indexes/worker.php");
	 } ?>      
 </div>
 </div>
 <div class="clearfix"></div>
<?php
require_once("../inc/footer.php");
 ?> 