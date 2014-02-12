<?php 
require_once("cg.php");
require_once("bd.php");
require_once("common.php");

function listLocations(){
	
	try
	{
		$sql="SELECT machine_location_id , location_name
		      FROM min_machine_location ORDER BY location_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		return $resultArray; 
	}
	catch(Exception $e)
	{
	}
}

function listlocationsAlpha(){
	
	try
	{
		$sql="SELECT machine_location_id , location_name
		      FROM min_machine_location
			  ORDER BY location_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		return $resultArray; 
	}
	catch(Exception $e)
	{
	}
}



function insertLocation($name){
	
	try
	{
		$name=clean_data($name);
		$name = ucfirst(strtolower($name));
		$duplicate=checkForDuplicateLocation($name);
		if(validateForNull($name) && !$duplicate)
		{
			$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="INSERT INTO
		      min_machine_location (location_name, created_by, last_updated_by, date_added, date_modified)
			  VALUES
			  ('$name', $admin_id, $admin_id, NOW(), NOW())";
		$result=dbQuery($sql);	
			
		return "success";
		}
		else
		{
		 return "error";
		}
	}
	catch(Exception $e)
	{
	}
	
}
function insertLocationIfNotDuplicate($name)
{
	try
	{
		$name=clean_data($name);
		$name = ucfirst(strtolower($name));
		$duplicate=checkForDuplicateLocation($name);
		if(validateForNull($name) && !$duplicate)
		{
			$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="INSERT INTO
		      min_machine_location (location_name, created_by, last_updated_by, date_added, date_modified)
			  VALUES
			  ('$name', $admin_id, $admin_id, NOW(), NOW())";
		$result=dbQuery($sql);	
			
		return "success";
		}
		else
		{
		 return $duplicate;
		}
	}
	catch(Exception $e)
	{
	}
	
	}

function deleteLocation($id){
	
	try
	{
		if(checkForNumeric($id) && !checkIfLocationInUse($id))
		{
		$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="DELETE FROM
			  min_machine_location
			  WHERE machine_location_id=$id";
		dbQuery($sql);	
		return  "success";
		}
		else
		{
			return "error";
			}
	}
	catch(Exception $e)
	{
	}
	
}

function updateLocation($id,$name){
	
	try
	{
		$name=clean_data($name);
		$name = ucfirst(strtolower($name));
		$duplicate=checkForDuplicateLocation($name,$id);
		if(validateForNull($name) && checkForNumeric($id) && !$duplicate)
		{
			
		$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="UPDATE min_machine_location
			  SET location_name='$name', last_updated_by=$admin_id, date_modified=NOW()
			  WHERE machine_location_id=$id";	  
		dbQuery($sql);
		return "success";	
		}
		else
		{
			return "error";
		}
	}
	catch(Exception $e)
	{
	}
	
}

function checkForDuplicateLocation($name,$id=false)
{
	try{
		$sql="SELECT machine_location_id 
			  FROM 
			  min_machine_location 
			  WHERE location_name='$name'";
		if($id==false)
		$sql=$sql."";
		else
		$sql=$sql." AND machine_location_id!=$id";		  
		$result=dbQuery($sql);	
		
		if(dbNumRows($result)>0)
		{
			$resultArray=dbResultToArray($result);
			
			return $resultArray[0][0]; //duplicate found
			} 
		else
		{
			return false;
			}	 
		}
	catch(Exception $e)
	{
		
		}
	
	}

function getLocationByID($id)
{
	$sql="SELECT machine_location_id, location_name
			  FROM 
			  min_machine_location 
			  WHERE machine_location_id=$id";
		$result=dbQuery($sql);	
		$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	{
		return $resultArray[0];
		}
	else
	{
		return false;
		}
	}
function checkIfLocationInUse($id)
{
	$sql="SELECT machine_location_id
	      FROM min_machines
		  WHERE machine_location_id=$id LIMIT 0, 1";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	{
		return true;
		}
		
		return false;
			
		  
	}	
?>