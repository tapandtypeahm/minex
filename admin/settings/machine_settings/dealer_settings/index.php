<?php
require_once "../../../../lib/cg.php";
require_once "../../../../lib/bd.php";
require_once "../../../../lib/machine-company-functions.php";
require_once "../../../../lib/machine-dealer-functions.php";
require_once "../../../../lib/location-functions.php";

if(isset($_SESSION['minexAdminSession']['admin_rights']))
$admin_rights=$_SESSION['minexAdminSession']['admin_rights'];

if(isset($_GET['view']))
{
	if($_GET['view']=='add')
	{
		$content="list_add.php";
	}
	else if($_GET['view']=='details')
	{
		$content="details.php";
		}
	else if($_GET['view']=='edit')
	{
		$content="edit.php";
		}	
	else
	{
		$content="list_add.php";
	}	
}
else
{
		$content="list_add.php";
}		
if(isset($_GET['action']))
{
	if($_GET['action']=='add')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(2,$admin_rights) || in_array(7,					$admin_rights)))
			{
		
		$result=insertMachineDealer($_POST["name"], $_POST["address"], $_POST["city"], $_POST["company"], $_POST["contactNo"], $_POST["contact_person"], $_POST["email"], $_POST["remarks"] );
		if($result=="success")
				{
				$_SESSION['ack']['msg']="Vehicle Dealer successfully added!";
				$_SESSION['ack']['type']=1; // 1 for insert
				}
				else{
					
				$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
				$_SESSION['ack']['type']=4; // 4 for error
				}
				
				header("Location: ".$_SERVER['PHP_SELF']);
				exit;
			}
			else
			{	
					$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
					$_SESSION['ack']['type']=5; // 5 for access
					header("Location: ".$_SERVER['PHP_SELF']);
					exit;
			}
	}
	if($_GET['action']=='delete')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(4,$admin_rights) || in_array(7,					$admin_rights)))
			{	
				$result=deleteVehicleDealer($_GET["lid"]);
				if($result=="success")
				{
				$_SESSION['ack']['msg']="Vehicle Dealer deleted Successfuly!";
				$_SESSION['ack']['type']=3; // 3 for delete
				}
				else
				{
					$_SESSION['ack']['msg']="Cannot delete Dealer! Dealer already in use!";
				$_SESSION['ack']['type']=6; // 6 for inUse
				}
				header("Location: ".$_SERVER['PHP_SELF']);
				exit;
			}
			else
			{	
					$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
					$_SESSION['ack']['type']=5; // 5 for access
					header("Location: ".$_SERVER['PHP_SELF']);
					exit;
			}
		}
	if($_GET['action']=='edit')
	{
		if(isset($_SESSION['minexAdminSession']['admin_rights']) && (in_array(3,$admin_rights) || in_array(7,					$admin_rights)))
			{
				
				$result=updateVehicleDealer($_POST["lid"],$_POST["name"], $_POST["address"], $_POST["city"], $_POST["company"], $_POST["contactNo"]);
				if($result=="success")
				{
				$_SESSION['ack']['msg']="Vehicle Dealer updated Successfuly!";
				$_SESSION['ack']['type']=2; // 2 for update
				header("Location: ".$_SERVER['PHP_SELF']);
				exit;
				}
				else
				{
					$_SESSION['ack']['msg']="Invalid Input OR Duplicate Entry!";
					$_SESSION['ack']['type']=4; // 4 for error
					header("Location: ".$_SERVER['PHP_SELF']."?view=edit&lid=".$_POST["lid"]);
					exit;
				}
				
			}
			else
			{	
					$_SESSION['ack']['msg']="Authentication Failed! Not enough access rights!";
					$_SESSION['ack']['type']=5; // 5 for access
					header("Location: ".$_SERVER['PHP_SELF']);
					exit;
			}
		}				
	}
?>

<?php
$pathLinks=array("Home","Registration Form","Manage Locations");
$selectedLink="settings";
$jsArray=array("jquery.validate.js","validators/vehicleDealers.js","generateContactNoDealer.js");
require_once "../../../../inc/template.php";
 ?>