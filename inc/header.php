<?php 
if (!defined('WEB_ROOT')) {
	exit;
}
if(isset($_SESSION['adminSession']['admin_id']))
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
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo WEB_ROOT; ?>js/tableToCSV.js"></script>

</head>

<body>
	<div id="mainDiv">
		<div id="header" class="no_print">
			<a href="<?php echo WEB_ROOT; ?>"><div id="logo">Minex</div></a>
				<div id="navigation">
            		<div id="nav">
                     <a id="userNameNav" href="#"><?php echo $_SESSION['adminSession']['admin_name']; ?> &#8711; </a> 
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
if(isset($_SESSION['adminSession']['admin_rights']))
{
	$admin_rights=$_SESSION['adminSession']['admin_rights'];
	}
 if(! (isset($_SESSION['adminSession']['admin_rights']) && (in_array(5,$admin_rights) || in_array(7,$admin_rights))) )
			{ ?> no_print <?php } ?>">
<div id="companyTitle"><?php if(isset($showTitle) && $showTitle==false){} else  echo getDepartmentNameById($_SESSION['adminSession']['department_id']);  ?></div>