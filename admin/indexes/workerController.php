<?php
require_once("../../lib/cg.php");
require_once("../../lib/bd.php");
$selectedLink="home";
require_once("../../lib/department-functions.php");
require_once("../../lib/takeAction-functions.php");

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

if($_GET['action']=='acknowledge')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(2,$admin_rights) || in_array(7,					$admin_rights)))
		{
		$result=acknowledgeAction($_GET["lid"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action Acknowledged successfully!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".WEB_ROOT."admin");
		exit;
		}
		else
		{	
		$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
		$_SESSION['ack']['type']=5; // 5 for access
		header("Location: ".WEB_ROOT."admin");
		exit;
			}
		}
if($_GET['action']=='done')
	{
		
		$result=setActionDone($_GET["lid"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action Updated successfully!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".WEB_ROOT."admin");
		exit;
		}	
if($_GET['action']=='help')
	{
		
		$result=NeedHelpForAction($_GET["lid"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Asked for Help successfully!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".WEB_ROOT."admin");
		exit;
		}	
if($_GET['action']=='notdone')
	{
		
		$result=setActionUnDone($_GET["lid"]);
		
		if($result=="success")
			{
			$_SESSION['ack']['msg']="Action Updated successfully!";
			$_SESSION['ack']['type']=1; // 1 for insert
			}
			else{
				
			$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
			$_SESSION['ack']['type']=4; // 4 for error
			}
		
		header("Location: ".WEB_ROOT."admin");
		exit;
		}				
?>