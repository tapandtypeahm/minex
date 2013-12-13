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

<h4 class="headingAlignment">City & Area Settings</h4>

<div class="settingsSection">

<div class="rowOne">
  <div class="package">
     
     <a href="general_settings/city_settings/">
     <div class="squareBox">
     
        <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     <div class="explanation">
     Manage City Settings
     </div>
     
     
     
     </div>
     <div class="package">
     
     <a href="general_settings/area_settings/">
     <div class="squareBox">
     
        <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     <div class="explanation">
     Manage Area Settings
     </div>
     
     
     
     </div>
     
     <div class="package">
     
     <a href="general_settings/merge_area_settings/">
     <div class="squareBox">
     
        <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     <div class="explanation">
     Merge Area Settings
     </div>
     
     
     
     </div>
     <div class="package">
     
     <a href="general_settings/area_group_settings/">
     <div class="squareBox">
     
        <div class="imageHolder">
         </div>
         
     </div>
     </a>
     
     <div class="explanation">
     Manage Area Group Settings
     </div>
     
     
     
     </div>
     
</div>
</div>     


</div> 