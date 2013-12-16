<?php 
require_once("cg.php");
require_once("common.php");
require_once("department-functions.php");
require_once("bd.php");





function insertMachine($name,$code, $description, $department_id)
{
	try
	{
		
	if(checkForNumeric($department_id) && $department_id>0  && checkForAlphaNumeric($code) && validateForNull($name,$code) && !checkForDuplicateMachine($code))
	{
	$name=clean_data($name);
	$description=clean_data($description);
	$department_id=clean_data($department_id);
	$code=clean_data($code);	

	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "insert into min_machines (machine_name, machine_code, description, department_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$name', '$code' , '$description', $department_id, $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address') ";
	
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

function checkForDuplicateMachine($code,$id=false)
{
	if(checkForAlphaNumeric($code))
	{
		$sql = "SELECT machine_id 
		        FROM min_machines 
		        WHERE machine_code='$code'";
		if($id!=false && checkForNumeric($id))
		$sql=$sql." AND machine_id!=$id";		
		$result=dbQuery($sql);
        $resultArray=dbResultToArray($result);
        
		
		if(count($resultArray)>0)
		{
			return true;
		}
		else
		return false;
		
	}
	
}

function listMachines()
{
	
	$sql="SELECT machine_id, machine_name, machine_code, min_machines.description, min_machines.department_id, department_name
	      FROM min_machines,min_departments
		  WHERE min_machines.department_id= min_departments.department_id";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}

function deleteMachine($id)
{
	try{
		$machines=listMachines();
		if(checkForNumeric($id) && !checkIfMachineInUse($id) && count($machines)>1)
		{
		$sql="DELETE FROM min_machines 
			  WHERE machine_id=$id";
		dbQuery($sql);	  
		return "success";
		}
		else if(count($machines)==1)
		{
			return "error1";
			}
		else
		{
			return "error";
			}
		}
	catch(Exception $e)
	{}
	
}

function checkIfMachineInUse($machine_id)
{

	// Will Depend on MDI Form, so if any MDI form has been filled up of that particular Machine ID, you can't DELETE that MAchine.
	 return false;	  	
}

function getMachinesFromDepartmentId($dep_id)
{
	$sql="SELECT machine_id, machine_name, machine_code, description
	      FROM min_machines
		  WHERE machine_id=$dep_id";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray;	
	
}

function getMachineNameFromMachineCode($code)
{
	$sql="SELECT machine_id, machine_name, description
	      FROM min_machines
		  WHERE machine_code=$code";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray;	
	
}

function GetMachineDetailsFromMachineId($m_id)
{
	$sql="SELECT machine_id, machine_name, machine_code, min_machines.date_added, min_machines.date_modified, min_machines.ip_created, min_machines.ip_modified, min_machines.description, min_departments.department_id, department_name, admin_name
	      FROM min_machines, min_departments, min_admin
		  WHERE machine_id=$m_id AND min_machines.department_id=min_departments.department_id AND
		  min_admin.admin_id=min_machines.created_by";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray[0];
	
}



function updateMachine($m_id, $department_id, $name, $code, $description)
{
	
			
			 
			$name=clean_data($name);
			$code=clean_data($code);
			$description=clean_data($description);
			
			if(validateForNull($name,$code) && checkForNumeric($department_id) && $department_id>0 && !checkForDuplicateMachine($code,$m_id))
			{
				
				
			$ip_address=$_SERVER['REMOTE_ADDR'];
			 
			
			
			$sql = "UPDATE min_machines 
					SET department_id = $department_id, machine_name = '$name', machine_code = '$code', description = '$description', date_modified = NOW() 
					WHERE machine_id=$m_id";
			$result = dbQuery($sql); 
			
			return "success";
			
		}
		else
		{
			return "error";	
		}
	}


	

?>

