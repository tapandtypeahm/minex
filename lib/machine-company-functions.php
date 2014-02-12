<?php 
require_once("cg.php");
require_once("location-functions.php");
require_once("machine-dealer-functions.php");
require_once("common.php");
require_once("bd.php");
		
function listMachineCompanies(){
	
	try
	{
		$sql="SELECT machine_company_id, company_name
			  FROM min_manufacturing_companies ORDER BY company_name";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray;
		else
		return false;	  
	}
	catch(Exception $e)
	{
	}
	
}	


function insertMachineCompany($name){
	try
	{
		$name=clean_data($name);
		$name = ucwords(strtolower($name));
		if(validateForNull($name) && !checkDuplicateMachineCompany($name))
		{
			$sql="INSERT INTO 
				min_manufacturing_companies(company_name)
				VALUES ('$name')";
		$result=dbQuery($sql);
		$company_id=dbInsertId();
	
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

function deleteMachineCompany($id){
	
	try
	{
		if(!checkifMachineCompanyInUse($id))
		{
		$sql="DELETE FROM min_manufacturing_companies
		      WHERE machine_company_id=$id";
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

function updateMachineCompany($id,$name){
	
	try
	{
		$name=clean_data($name);
		$name = ucwords(strtolower($name));
		if(validateForNull($name) && checkForNumeric($id) && !checkDuplicateMachineCompany($name,$id))
		{
		$sql="UPDATE min_manufacturing_companies
			  SET company_name='$name'
			  WHERE machine_company_id=$id";
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

function getMachineCompanyById($id){
	
	try
	{
		if(checkForNumeric($id))
		{
		$sql="SELECT machine_company_id, company_name
			  FROM min_manufacturing_companies
			  WHERE machine_company_id=$id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0];
		else
		return false;
		}
	}
	catch(Exception $e)
	{
	}
	
}

function getMachineCompanyNameById($id){
	
	try
	{
		if(checkForNumeric($id))
		{
		$sql="SELECT company_name
			  FROM min_manufacturing_companies
			  WHERE machine_company_id=$id";
		$result=dbQuery($sql);
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0][0];
		else
		return false;
		}
	}
	catch(Exception $e)
	{
	}
	
}

function checkDuplicateMachineCompany($name,$id=false)
{
	if(validateForNull($name))
	{
		$sql="SELECT machine_company_id
			  FROM min_manufacturing_companies
			  WHERE company_name='$name'";
		if($id==false)
		$sql=$sql."";
		else
		$sql=$sql." AND machine_company_id!=$id";		  
		$result=dbQuery($sql);	
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		{
			return $resultArray[0][0]; //duplicate found
			} 
		else
		{
			return false;
			}
	}
}	

function checkifMachineCompanyInUse($id)
{
	if(checkForNumeric($id))
	{
	$sql="SELECT machine_company_id
	      FROM min_machines
		  Where machine_company_id=$id";
	$result=dbQuery($sql);	  
	if(dbNumRows($result)>0)
	return true;
	else 
	return false;
	}
}		
?>