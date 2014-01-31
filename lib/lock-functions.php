<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");
require_once("mdi-functions.php");


function insertLock($name, $applied, $removed, $mdi_id)
{
	
	try
	{
		if(!validateForNull($removed))	
	{
		$removed="1970-01-01 00:00:00";
	}
		
	if(checkForNumeric($mdi_id) && validateForNull($name, $applied, $removed))
	{
		
	$applied=str_replace("/","-",$applied);
	$applied=date('Y-m-d H:i:s',strtotime($applied));
	
	$lock_removed=str_replace("/","-",$removed);
	$removed=date('Y-m-d H:i:s',strtotime($removed));
	
	$name=clean_data($name);
	$applied=clean_data($applied);
	$removed=clean_data($removed);
		
	$sql = "insert into min_lock (lock_by, lock_applied, lock_removed, mdi_id) VALUES ('$name', '$applied' , '$removed', $mdi_id) ";
	
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

function listLockFromMDIId($m_id)
{
		
	
	$sql="SELECT lock_id, lock_by, lock_applied, lock_removed
	      FROM min_lock
		  WHERE mdi_id=$m_id";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0]; 
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


function updateLock($lock_id, $lock_by, $lock_applied, $lock_removed, $mdi_id)


{
		if(!validateForNull($lock_removed))	
	{
		$lock_removed ="1970-01-01 00:00:00";
	}
	         
	
			$lock_applied=str_replace("/","-",$lock_applied);
			$lock_applied=date('Y-m-d H:i:s',strtotime($lock_applied));
	
			$lock_removed=str_replace("/","-", $lock_removed);
			$lock_removed=date('Y-m-d H:i:s',strtotime($lock_removed));
			 
			if(validateForNull($lock_by) && checkForNumeric($lock_id, $mdi_id) && $mdi_id>0)
			{
			
				
		$sql = "UPDATE min_lock
					SET lock_by = '$lock_by', lock_applied = '$lock_applied', lock_removed = '$lock_removed', mdi_id='$mdi_id'
					WHERE lock_id=$lock_id";
			$result = dbQuery($sql); 
			
			return "success";
			
		    }
			else
			{
				return "error";	
			}
	
	
			
}

?>
