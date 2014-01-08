<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");
require_once("mdi-functions.php");


function insertLock($name, $applied, $removed, $mdi_id)
{
	
	try
	{
		
	if(checkForNumeric($mdi_id) && validateForNull($name, $applied, $removed))
	{
	$name=clean_data($name);
	$applied=clean_data($applied);
	$removed=clean_data($removed);
		

	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	$sql = "insert into min_lock (lock_by, lock_applied, lock_removed, mdi_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$name', '$applied' , '$removed', $mdi_id, $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address') ";
	
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


function listLocks()
{
		
	
	$sql="SELECT lock_id, lock_by, lock_applied, lock_removed, mdi_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified
	      FROM min_lock";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}

function deleteLock($id)
{
	try{
		
		if(checkForNumeric($id))
		{
		$sql="DELETE FROM min_lock 
			  WHERE lock_id=$id";
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


?>

