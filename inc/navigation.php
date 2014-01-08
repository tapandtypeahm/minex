
            <a  href="<?php echo WEB_ROOT ?>admin/"><div class="link <?php if($selectedLink=="home") { ?> selected <?php } ?>">
            Home
           </div></a>
           <?php    $departments_without_maintenance=listNonCrudeWithoutMaintenanceDepartmentsIDs();  if(in_array($_SESSION['minexAdminSession']['department_id'],$departments_without_maintenance)) { ?>
           <a  href="<?php echo WEB_ROOT ?>admin/MDI"><div class="link <?php if($selectedLink=="mdi") { ?> selected <?php } ?>">
            MDI Form
           </div></a>
            <?php } ?>
            
           <?php $maintenance_id=getMaintenanceDepartmentId(); if($_SESSION['minexAdminSession']['department_id']==$maintenance_id){ ?>
           <a  href="<?php echo WEB_ROOT ?>admin/maintenanceMDI"><div class="link <?php if($selectedLink=="mdi") { ?> selected <?php } ?>">
            MDI Form
           </div></a>
            
           
           
            <a  href="<?php echo WEB_ROOT ?>admin/reports/"><div class="link <?php if($selectedLink=="reports") { ?> selected <?php } ?>">
           Reports
           </div></a>
			
           
            <a  href="<?php echo WEB_ROOT ?>admin/settings/"><div class="link <?php if($selectedLink=="settings") { ?> selected <?php } ?>">
           Settings
           </div></a>
           
           <?php } ?>
           <div class="clearfix"></div>