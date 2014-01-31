<?php 
require_once("cg.php");
require_once("common.php");
require_once("department-functions.php");
require_once("bd.php");




function insertAction($name, $description, $department_id, $mdi_id)
{
	
	try
	{
	if(!validateForNull($name))
	{
		$name="NA";
	}	
	if(checkForNumeric($department_id, $mdi_id) && $department_id>0 && $mdi_id>0 && validateForNull($name))
	{
		
		
	$name=clean_data($name);
	$description=clean_data($description);
	$department_id=clean_data($department_id);
	$mdi_id=clean_data($mdi_id);
		

	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "insert into min_take_action (assign_name, description, department_id, mdi_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$name', '$description', $department_id, $mdi_id, $admin_id, $admin_id, NOW(), NOW() , '$ip_address', '$ip_address') ";
	
	$result=dbQuery($sql);	  
	return "success";
	}
	else
	return "error";
	}
	
	catch(Exception $e)
	{
		return "Error";
	}
	
	
}

function deleteAction($id)
{
	try{
		
		if(checkForNumeric($id))
		
		{
		
		$sql="DELETE FROM min_take_action 
			  WHERE action_id=$id";
		dbQuery($sql);	  
		return "success";
		}
		
		else
		{
			return "error";
			}
		}
	catch(Exception $e)
	{}
	
}



function getActionDetailsFromDepartmentId($dep_id)
{
	$sql="SELECT action_id, assign_name, description, mdi_id
	      FROM min_take_action
		  WHERE department_id=$dep_id";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray;	
	
}

function getActionDepartmentFromActionId($action_id)
{
	$sql="SELECT department_name
	      FROM min_take_action, min_departments
		  WHERE min_departments.department_id=min_take_action.department_id AND min_take_action.action_id=$action_id";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
    return $resultArray[0][0];	
	else
	return false;
}



function getActionDetailsFromActionId($a_id)
{
	$sql="SELECT action_id, assign_name, description, mdi_id, min_take_action.date_added, min_take_action.date_modified, min_take_action.description, min_departments.department_id, department_name, admin_name
	      FROM min_take_action, min_departments, min_admin
		  WHERE action_id=$a_id AND min_take_action.department_id=min_departments.department_id AND
		  min_admin.admin_id=min_take_action.created_by";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray[0];
	
}

function getMdiIdFromActionId($a_id)
{
	$sql="SELECT  mdi_id
	      FROM min_take_action
		  WHERE action_id=$a_id";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
    return $resultArray[0][0];
    
	
}




function updateAction($a_id, $department_id, $name, $description)
{
	
			
			 
			$name=clean_data($name);
			$description=clean_data($description);
			
			if(validateForNull($name) && checkForNumeric($department_id) && $department_id>0 && !checkForDuplicateMachine($a_id))
			{
				
				
			$ip_address=$_SERVER['REMOTE_ADDR'];
			 $admin_id=$_SESSION['minexAdminSession']['admin_id'];
			
			
			$sql = "UPDATE min_take_action 
					SET department_id = $department_id, assign_name = '$name', description = '$description', date_modified = NOW(), ip_modified = $ip_address, last_updated_by = $admin_id  
					WHERE action_id=$a_id";
			$result = dbQuery($sql); 
			
			return "success";
			
		}
		else
		{
			return "error";	
		}
	}

function getAllActionForMDIID($mdi_id)
{
	$sql="SELECT action_id, assign_name, min_take_action.description, department_name, min_take_action.created_by, min_take_action.last_updated_by, min_take_action.date_added, min_take_action.date_modified, min_take_action.ip_created, min_take_action.ip_modified
	      FROM min_take_action, min_departments
		  WHERE min_departments.department_id=min_take_action.department_id  AND min_take_action.mdi_id = $mdi_id
		  ORDER BY min_take_action.date_added ASC";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
    return $resultArray;	
	else
	return false;
	
	
}

function getTotalActionsForMDIID($mdi_id)
{
	if(checkForNumeric($mdi_id))
	{
		$sql="SELECT action_id FROM min_take_action
		      WHERE mdi_id=$mdi_id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return dbNumRows($result);
		else
		return 0;
		
		}
	
	}
function getUnAcknowledgedActionForCrudeDepartment($id)
{
	if(checkForNumeric($id))
	{
		
		}
	}
	

?>

