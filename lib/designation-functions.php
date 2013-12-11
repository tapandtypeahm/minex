<?php 
require_once("cg.php");
require_once("bd.php");
require_once("common.php");

function listDesignations(){
	
	try
	{
		$sql="SELECT designation_id,designation_name, parent_id
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
		$admin_id=$_SESSION['adminSession']['admin_id'];
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
		$admin_id=$_SESSION['adminSession']['admin_id'];
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
		$admin_id=$_SESSION['adminSession']['admin_id'];
		$sql="UPDATE min_designation
			  SET designation_name='$name', parent_id=$parent_id, department_id=$department_id, last_updated_by=$admin_id, date_modified=NOW(), ip_modified=$ip_address
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
	$sql="SELECT designation_id, designation_name, parent_id, department_id
			  FROM 
			  min_designation 
			  WHERE designation_id=$id";
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
	      FROM min_admin_user
		  WHERE designation_id=$id LIMIT 0, 1";
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
	
?>