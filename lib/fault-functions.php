<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");




function insertFault($name)
{
	try
	{
		
	if(validateForNull($name) && !checkForDuplicateFault($name))
	{
	$name=clean_data($name);
		

		
	$sql = "insert into min_type_of_fault(fault_name) VALUES ('$name') ";
	
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

function checkForDuplicateFault($name,$id=false)
{
	if(validateForNull($name))
	{
		$sql = "SELECT fault_id 
		        FROM min_type_of_fault 
		        WHERE fault_name='$name'";
		if($id!=false && checkForNumeric($id))
		$sql=$sql." AND fault_id!=$id";		
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

function listFaults()
{
	
	$sql="SELECT fault_id, fault_name
	      FROM min_type_of_fault";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}

function deleteFault($id)
{
	try{
		$faults=listFaults();
		if(checkForNumeric($id) && !checkIfFaultInUse($id) && count($faults)>1)
		{
		$sql="DELETE FROM min_type_of_fault 
			  WHERE fault_id=$id";
		dbQuery($sql);	  
		return "success";
		}
		else if(count($faults)==1)
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

function checkIfFaultInUse($fault_id)
{
    $sql="SELECT fault_id
	      FROM min_MDI_form
		  WHERE fault_id = $fault_id";
   $result=dbQuery($sql);
    $check = dbNumRows($result);
	if($check>0)
	return true;
	
	 return false;	  	
}





function getFaultNameFromFaultId($f_id)
{
	$sql="SELECT fault_name
	      FROM min_type_of_fault
		  WHERE fault_id=$f_id";
   $result=dbQuery($sql);
    $resultArray=dbResultToArray($result);
    return $resultArray[0];
	
}



function updateFault($f_id, $name)
{
	     $name=clean_data($name);
		
		if(validateForNull($name) && checkForNumeric($f_id) && !checkForDuplicateFault($name,$f_id))
			{
				
			$sql = "UPDATE min_type_of_fault 
					SET fault_name = '$name'
					WHERE fault_id=$f_id";
			$result = dbQuery($sql); 
			
			return "success";
			
		}
		else
		{
			return "error";	
		}
	}
?>