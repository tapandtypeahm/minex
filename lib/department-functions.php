<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");





function insertDepartment($name,$parent_id, $description)
{
	try
	{
	if(checkForNumeric($parent_id) && $parent_id>=0 && validateForNull($name) && !checkForDuplicateDepartment($name,$parent_id))
	{
	$name=clean_data($name);
	$description=clean_data($description);
	$parent_id=clean_data($parent_id);	
	$admin_id=$_SESSION['adminSession']['admin_id'];
	$admin_id=12; //testing
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "insert into min_departments (department_name, parent_id, description, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$name', '$parent_id', '$description', $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address') ";
	
	$result=dbQuery($sql);	  
	$ourCompanyId=dbInsertId();
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

function checkForDuplicateDepartment($name, $parent_id)
{
	if(validateForNull($name) && checkForNumeric($parent_id) && $parent_id>=0)
	{
		$sql = "SELECT department_id 
		        FROM min_departments 
		        WHERE department_name='$name' && parent_id=$parent_id";
				
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

function getAllChildDepartmentsFromItsParent($parent_id)
{
	
	}

function getDepartmentFromItsParent($parent_id)
{
	$sql="SELECT department_name
	      FROM min_departments
		  WHERE department_id=$parent_id";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray;	
	
}

function getDepartmentById($id)
{
	$sql="SELECT department_name , description
	      FROM min_departments
		  WHERE department_id=$id";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray[0];	
	
}

function getDepartmentNameById($id)
{
	$sql="SELECT department_name 
	      FROM min_departments
		  WHERE department_id=$id";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray[0][0];	
	
}


function listDepartment()
{
	
	$sql="SELECT department_id, department_name, parent_id , description
	      FROM min_departments
		  ORDER BY department_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		for($i=0;$i<count($resultArray);$i++)
		{
			
			$parent_id=$resultArray[$i]['parent_id'];
			if($parent_id>0)
			{
			$parent_array=getDepartmentById($parent_id);
			
			$parent_name=$parent_array['department_name'];
			}
			else
			$parent_name="Super Parent";
			$resultArray[$i]['parent_name']=$parent_name;
		}
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}

function deleteDepartment($id)
{
	try{
		
		$department=listDepartment();
		if(checkForNumeric($id) && !checkIfDepartmentInUse($id) && count($department)>1)
		{
		$sql="DELETE FROM
		      min_departments 
			  WHERE department_id=$id";
		dbQuery($sql);	  
		return "success";
		}
		else if(count($department)==1)
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

function checkIfDepartmentInUse($department_id)
{

	$sql="SELECT department_id 
	      FROM min_admin
	      WHERE department_id=$department_id";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	return true;

	 
	 $sql="SELECT department_id 
	      FROM min_designation
	      WHERE department_id=$department_id";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	return true;
	
	$sql="SELECT department_id 
	      FROM min_machines
	      WHERE department_id=$department_id";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	return true;
	 	  
	 	  	 
	return false;	  	
}
	

?>
