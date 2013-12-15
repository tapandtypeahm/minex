<?php 
require_once("cg.php");
require_once("bd.php");
require_once("common.php");

function listDesignations(){
	
	try
	{
		$sql="SELECT designation_id,designation_name, parent_id,department_id
		      FROM min_designation ORDER BY designation_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		return $resultArray; 
	}
	catch(Exception $e)
	{
	}
}

function listDesignationsAlpha(){
	
	try
	{
		$sql="SELECT designation_id,designation_name
		      FROM min_designation
			  ORDER BY designation_name";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		return $resultArray; 
	}
	catch(Exception $e)
	{
	}
}



function insertdesignation($name,$parent_id,$department_id){
	
	try
	{
		$name=clean_data($name);
		$name = ucfirst(strtolower($name));
		$duplicate=checkForDuplicatedesignation($name,$department_id);
		if(validateForNull($name) && !$duplicate && checkForNumeric($parent_id))
		{
		$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$sql="INSERT INTO
		      min_designation (designation_name, parent_id, department_id,created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified)
			  VALUES
			  ('$name', $parent_id, $department_id, $admin_id, $admin_id, NOW(), NOW(), '$ip_address', '$ip_address')";
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

function deletedesignation($id){
	
	try
	{
		if(checkForNumeric($id) && !checkIfdesignationInUse($id))
		{
		$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="DELETE FROM
			  min_designation
			  WHERE designation_id=$id";
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

function updatedesignation($id,$name,$parent_id,$department_id){
	
	try
	{
		$name=clean_data($name);
		$name = ucfirst(strtolower($name));
		$duplicate=checkForDuplicatedesignation($name,$department_id,$id);
		if(validateForNull($name) && checkForNumeric($id) && !$duplicate && checkForNumeric($parent_id))
		{
		$ip_address=$_SERVER['REMOTE_ADDR'];	
		$admin_id=$_SESSION['minexAdminSession']['admin_id'];
		$sql="UPDATE min_designation
			  SET designation_name='$name', parent_id=$parent_id, department_id=$department_id, last_updated_by=$admin_id, date_modified=NOW(), ip_modified='$ip_address'
			  WHERE designation_id=$id";	  
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

function checkForDuplicatedesignation($name,$department_id,$id=false)
{
	try{
		$sql="SELECT designation_id 
			  FROM 
			  min_designation 
			  WHERE designation_name='$name' AND department_id=$department_id";
		if($id==false)
		$sql=$sql."";
		else
		$sql=$sql." AND designation_id!=$id";		  
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

function getdesignationByID($id)
{
	$sql="SELECT designation_id, designation_name, min_designation.parent_id, min_departments.department_id, department_name
			  FROM 
			  min_designation , min_departments 
			  WHERE designation_id=$id
			  AND min_designation.department_id = min_departments.department_id";
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

function getdesignationNameByID($id)
{
	if($id==0)
	return "Super Parent";
	$sql="SELECT  designation_name
			  FROM 
			  min_designation 
			  WHERE designation_id=$id";
		$result=dbQuery($sql);	
		$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	{
		return $resultArray[0][0];
		}
	else
	{
		return false;
		}
	}	
function checkIfdesignationInUse($id)
{
	$sql="SELECT designation_id
	      FROM min_admin
		  WHERE designation_id=$id AND is_active=1";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	{
		return true;
		}
		return false;  
	}	
function getDesignationsForDepartment($department_id)
{
	if(checkForNumeric($department_id))
	{
		
		$sql="SELECT designation_id, designation_name, parent_id
	      FROM min_designation
		  WHERE department_id=$department_id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		return $resultArray;  
		}
}

function getChildDepartmentsFromItsParent($designation_id)
{
	if(checkForNumeric($designation_id) && $designation_id>=0)
	{
		$sql="SELECT designation_id, designation_name, parent_id, department_id
	      FROM min_designation
		  WHERE parent_id=$designation_id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		return $resultArray;  
		}
	
	}
	
function getChildDesignationIdsFromItsParent($designation_id)
{
	if(checkForNumeric($designation_id) && $designation_id>=0)
	{
		$sql="SELECT designation_id
	      FROM min_designation
		  WHERE parent_id=$designation_id";
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
	
	}	

function getBiggestDesignationForDepartment($department_id)
{
	if(checkForNumeric($department_id))
	{
		$sql="SELECT designation_id,designation_name,parent_id
			from min_designation
			WHERE parent_id=0 AND department_id=$department_id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);	
		if(dbNumRows($result)>0)
		return $resultArray[0];
		else
		return false;
		}
	}	
function getSmallestDesignationForDepartment($department_id)
{
	
	$biggest_designation=getBiggestDesignationForDepartment($department_id);
	if($biggest_designation!=false)
	{
	$biggest_designation_id=$biggest_designation[0];
	$smallerDesgnations=getDesignationIdsForDepartmentDescendingOrder($biggest_designation_id);
	$count=count($smallerDesgnations);
	$smallest_designation_id=$smallerDesgnations[$count-1];
	$smallest_designation=getdesignationByID($smallest_designation_id);
	return $smallest_designation;
	}
	else
	return false;
	}		
function getDesignationIdsForDepartmentDescendingOrder($designation_id)
{
	if(checkForNumeric($designation_id))
	{
		$returnarray=array();
		$directChildren=getChildDesignationIdsFromItsParent($designation_id);
		
		if($directChildren!=false)
		{
			
			foreach($directChildren as $de_id)
			{
					$returnarray[]=$de_id;
					$children=getDesignationIdsForDepartmentDescendingOrder($de_id);
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


	
?>