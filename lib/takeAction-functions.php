<?php 
require_once("cg.php");
require_once("common.php");
require_once("department-functions.php");
require_once("mdi-functions.php");
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
	
	AcknowledgeMDI($mdi_id);
	 
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
	$sql="SELECT action_id, assign_name, min_take_action.description, mdi_id, min_take_action.date_added, min_take_action.date_modified, min_take_action.description, min_departments.department_id, department_name, admin_name, crude_acknowledged, action_done, need_help, need_help_time
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
	$sql="SELECT action_id, assign_name, min_take_action.description, department_name, mdi_id, crude_acknowledged, action_done, min_take_action.created_by, min_take_action.last_updated_by, min_take_action.date_added, min_take_action.date_modified, min_take_action.ip_created, min_take_action.ip_modified
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
function getUnAcknowledgedActionForCrudeDepartment($department_id)
{
	if(checkForNumeric($department_id))
	{
	$sql="SELECT action_id, assign_name, min_take_action.description, department_name, mdi_id, crude_acknowledged, action_done, min_take_action.created_by, min_take_action.last_updated_by, min_take_action.date_added, min_take_action.date_modified, min_take_action.ip_created, min_take_action.ip_modified
	      FROM min_take_action, min_departments
		  WHERE min_departments.department_id=min_take_action.department_id AND crude_acknowledged=0 AND min_take_action.department_id = $department_id
		  ORDER BY min_take_action.date_added ASC";
   	$result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
    return $resultArray;	
	else
	return false;	
	}
}

function getEligibleActionsForCrudeDepartment($department_id) // if action is done and not done yet i.e action_done=0
{
	if(checkForNumeric($department_id))
	{
	$sql="SELECT action_id, assign_name, min_take_action.description, department_name, mdi_id, crude_acknowledged, action_done, min_take_action.created_by, min_take_action.last_updated_by, min_take_action.date_added, min_take_action.date_modified, min_take_action.ip_created, min_take_action.ip_modified
	      FROM min_take_action, min_departments
		  WHERE min_departments.department_id=min_take_action.department_id AND action_done=0 AND min_take_action.department_id = $department_id
		  ORDER BY min_take_action.date_added ASC";
   	$result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
    return $resultArray;	
	else
	return false;	
	}
}

function acknowledgeAction($action_id)
{
	if(checkForNumeric($action_id))
	{
		$sql="UPDATE min_take_action SET crude_acknowledged=1 WHERE action_id=$action_id";
		$result=dbQuery($sql);
		return "success";
		}
	return "error";	
	}

function setActionDone($action_id)
{
	if(checkForNumeric($action_id))
	{
		$sql="UPDATE min_take_action SET action_done=2 WHERE action_id=$action_id";
		$result=dbQuery($sql);
		return "success";
		}
	return "error";	
}	

function setActionUnDone($action_id)
{
	if(checkForNumeric($action_id))
	{
		$sql="UPDATE min_take_action SET action_done=1 WHERE action_id=$action_id";
		$result=dbQuery($sql);
		return "success";
		}
	return "error";	
}	

function NeedHelpForAction($action_id)
{
	if(checkForNumeric($action_id))
	{
		$sql="UPDATE min_take_action SET need_help=1,need_help_time=NOW() WHERE action_id=$action_id";
		$result=dbQuery($sql);
		return "success";
		}
	return "error";	
}

function getStatusForAction($action_id)
{
	if(checkForNumeric($action_id))
	{
		
		$action=getActionDetailsFromActionId($action_id);
		
		if($action['action_done']==1)
		return "NOT DONE";
		else if($action['action_done']==2)
		return "DONE";
		else if($action['need_help']==1)
		return "HELP NEEDED";
		else if($action['crude_acknowledged']==1)
		return "ACKNOWLEDGED";
		else return "UNACKNOWLEDGED";
		}
}	

function updateActionAsOld($action_id)
{
	if(checkForNumeric($action_id))
	{
	$sql="UPDATE min_take_action SET is_new=1 WHERE action_id=$action_id";
	$result=dbQuery($sql);
	return "success";
	}
	return "error";
}

function getNewActionsForDepartment($department_id)
{
	if(checkForNumeric($department_id))
	{
	$sql="SELECT COUNT(action_id)
	      FROM min_take_action
		  WHERE min_take_action.department_id = $department_id AND is_new=0";
   	$result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
    return $resultArray[0][0];	
	else
	return 0;	
		
		}
	return 0;
	}
?>
