<div class="adminContentWrapper wrapper">
<h4 class="headingAlignment">General Settings</h4>

<div class="settingsSection">

<div class="rowOne"> <!-- row one started -->

     <div class="package"> <!-- package started -->
     
     <a href="general_settings/department_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Departments
     </div>
     
     </div>        <!-- package completed -->
     
     
      <div class="package">
     
     <a href="general_settings/location_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Locations
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
     Manage Users
     </div>
     
     </div>
     <?php } ?>
    
     
  </div> <!-- row one completed -->
  
  <h4 class="headingAlignment">Machine Settings</h4>

  
  <div class="rowOne"> <!-- row two started -->

     <div class="package">
     
     <a href="machine_settings/machine_settings/">
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
     
     <a href="machine_settings/company_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Manufacturing Companies
     </div>
     
     </div>
     
      <div class="package">
     
     <a href="machine_settings/dealer_settings/">
     <div class="squareBox">
     
         <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     
     <div class="explanation">
     Manage Dealers
     </div>
     
     </div>
     
   </div>  <!-- row two completed -->
  
     
</div> <!-- settings section completed -->

</div> 