
<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");
require_once("machine-functions.php");

function listCrudeDepartments()
{
	
	$sql="SELECT department_id, department_name, parent_id , description
	      FROM min_departments
		  WHERE crude=1
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
	
function listCrudeDepartmentsIDs()
{
	
	$sql="SELECT department_id
	      FROM min_departments
		  WHERE crude=1
		  ORDER BY department_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		$return_array=array();
		if(dbNumRows($result)>0)
		{
		foreach($resultArray as $re)
		{
			$return_array[]=$re[0];
			}	
		return $return_array; 
		}
		else
		return false;
	
	
	return false;
}		
	
function listNonCrudeDepartments()
{
	
	$sql="SELECT department_id, department_name, parent_id , description
	      FROM min_departments
		  WHERE crude=0
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

function listNonCrudeWithoutMaintenanceDepartments()
{
	$maintenance_id=getMaintenanceDepartmentId();
	if($maintenance_id!=false && is_numeric($maintenance_id))
	{
	$sql="SELECT department_id, department_name, parent_id , description
	      FROM min_departments
		  WHERE crude=0 AND department_id!=$maintenance_id
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
	return false;
}		

function listNonCrudeWithoutMaintenanceDepartmentsIDs()
{
	$maintenance_id=getMaintenanceDepartmentId();
	if($maintenance_id!=false && is_numeric($maintenance_id))
	{
	$sql="SELECT department_id
	      FROM min_departments
		  WHERE crude=0 AND department_id!=$maintenance_id
		  ORDER BY department_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		$return_array=array();
		if(dbNumRows($result)>0)
		{
		foreach($resultArray as $re)
		{
			$return_array[]=$re[0];
			}	
		return $return_array; 
		}
		else
		return false;
	
	}
	return false;
}		


function getMaintenanceDepartmentId()
{
	$sql="SELECT department_id, department_name, parent_id , description
	      FROM min_departments
		  WHERE department_name= 'Maintenance'";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	return $resultArray[0][0];
	else
	return false;
	}


function insertDepartment($name,$parent_id, $description, $crude=0)
{
	try
	{
	if(checkForNumeric($parent_id,$crude) && $parent_id>=0 && validateForNull($name) && !checkForDuplicateDepartment($name,$parent_id))
	{
	
	$name=clean_data($name);
	$name=ucwords($name);
	$description=clean_data($description);
	$parent_id=clean_data($parent_id);
	$crude=clean_data($crude);	
	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "insert into min_departments (department_name, parent_id, crude, description, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$name', '$parent_id', $crude, '$description', $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address') ";
	$result=dbQuery($sql);	  
	$department_id=dbInsertId();
	insertGeneralUtilityForDepartment($department_id);
	
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

function updateDepartment($department_id,$name,$parent_id, $description, $crude=0)
{
	try
	{
	
	if(checkForNumeric($parent_id,$crude) && $parent_id>=0 && validateForNull($name) && !checkForDuplicateDepartment($name,$parent_id,$department_id))
	{
	$name=clean_data($name);
	$name=ucwords($name);
	$description=clean_data($description);
	$parent_id=clean_data($parent_id);	
	$crude=clean_data($crude);
	$department_id=clean_data($department_id);
	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "UPDATE min_departments
	       SET department_name = '$name', parent_id = $parent_id, crude=$crude, description = '$description', last_updated_by = $admin_id, date_modified = NOW(), ip_modified = '$ip_address' 
		   WHERE department_id=$department_id";	
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
function listDisjointDepartment($department_id)
{
	
	if(checkForNumeric($department_id))
	{
		$children_array=getAllChildrenIdsForDepartment($department_id);
		$children_string=implode(",",$children_array);
		if(!empty($children_array))
		$children_string=$department_id.",".$children_string;
		else
		$children_string=$department_id;
		$sql="SELECT department_id, department_name , description, parent_id
	      FROM min_departments
		  WHERE department_id NOT IN ($children_string)";
		$result=dbQuery($sql);
        $resultArray=dbResultToArray($result);
        if(dbNumRows($result)>0)
		return $resultArray;
		else
		return false;
		}
}

function checkForDuplicateDepartment($name, $parent_id, $department_id=false)
{
	if(validateForNull($name) && checkForNumeric($parent_id) && $parent_id>=0)
	{
		
		$sql = "SELECT department_id 
		        FROM min_departments 
		        WHERE department_name='$name' AND parent_id=$parent_id";
		if($department_id!=false && is_numeric($department_id))
		$sql=$sql." AND department_id!=$department_id";		
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
		if(checkForNumeric($parent_id))
		{
			$department=getDepartmentById($parent_id);
			$returnArray=array();
			$count=0;
			$returnArray[$count]=$department;
			$directChildren=getBFSChildrenForDepartment($parent_id);
			$returnArray[$count]['children']=$directChildren;	
		}
}

function getAllChildrenIdsForDepartment($department_id)
{
	if(checkForNumeric($department_id))
	{
		
		$returnarray=array();
		$directChildren=getDepartmentIdsFromItsParent($department_id);
		if($directChildren!=false)
		{
			
			foreach($directChildren as $de_id)
			{
					$returnarray[]=$de_id;
					$children=getAllChildrenIdsForDepartment($de_id);
					if($children!=false)
					{
					foreach($children as $ch)
					{
					$returnarray[]=$ch;
					}
					}
			}
			
					
		}
		return $returnarray;		
	}
	
	}

function getBFSChildrenForDepartment($department_id)
{

	if(checkForNumeric($department_id))
	{
		
		$returnarray=array();
		$directChildren=getDepartmentIdsFromItsParent($department_id);
		
		if($directChildren!=false)
		{
			$returnarray[$department_id]=$directChildren;
			foreach($directChildren as $de_id)
			{
					$children=getBFSChildrenForDepartment($de_id);
					if($children!=false)
					$returnarray[$de_id]=$children;
			}
					
		}
		return $returnarray;		
	}
}

function getDepartmentFromItsParent($parent_id)
{
	$sql="SELECT department_id, department_name, description, parent_id
	      FROM min_departments
		  WHERE parent_id=$parent_id";

   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(is_array($resultArray) && dbNumRows($result)>0)
    return $resultArray;	
	else
	return false;
	
}

function getDepartmentIdsFromItsParent($parent_id)
{
	
	$sql="SELECT department_id
	      FROM min_departments
		  WHERE parent_id=$parent_id";

   	$result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
	if(is_array($resultArray) && dbNumRows($result)>0)
	{
		$returnArray=array();
		foreach($resultArray as $re)
		{
			$returnArray[]=$re[0];
			}
   	return $returnArray;
	}
	else
	return false;
	
}

function getDepartmentById($id)
{
	$sql="SELECT department_id, department_name , description, parent_id
	      FROM min_departments
		  WHERE department_id=$id";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray[0];	
	
}

function getDepartmentNameById($id)
{
	if($id==0)
	return "Super Parent";
	   
	$sql="SELECT department_name,parent_id
	      FROM min_departments
		  WHERE department_id=$id";
	
   $result=dbQuery($sql);
   
   $resultArray=dbResultToArray($result);
   if(count($resultArray)>0)
   {
   return $resultArray[0][0];	
   }
	
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

function insertGeneralUtilityMachinesForAllDepartment()
{
	$departments=listNonCrudeDepartments();
	foreach($departments as $department)
	{
		$department_id=0;
		$department_id=$department['department_id'];
		insertGeneralUtilityForDepartment($department_id);
		}
}
?>