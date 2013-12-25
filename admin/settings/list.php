<div class="adminContentWrapper wrapper">
<h4 class="headingAlignment">General Settings</h4>

<div class="settingsSection">

<div class="rowOne">

     <div class="package">
     
     <a href="general_settings/department_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Departments
     </div>
     
     </div>
     
     <div class="package">
     
     <a href="general_settings/designation_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Designations
     </div>
     
     </div>
     
       <div class="package">
     
     <a href="general_settings/machine_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Machines
     </div>
     
     </div>
     
     
     
     <div class="package">
     
     <a href="general_settings/fault_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Faults
     </div>
     
     </div>
     
    
     <?php if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(6,$admin_rights) || in_array(7,					$admin_rights)))
			{ ?>
     <div class="package">
     
     <a href="general_settings/adminuser_settings/">
     <div class="squareBox">
         <div class="imageHolder">
         </div>
     </div>
     </a>
     
     <div class="explanation">
     Manage Admin Users
     </div>
     
     </div>
     <?php } ?>
    
     
  </div>
     
</div>

   


</div> 