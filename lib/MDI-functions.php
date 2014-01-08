<?php 
require_once("cg.php");
require_once("common.php");
require_once("department-functions.php");
require_once("bd.php");
require_once("smsAndEmail-functions.php");
require_once("takeAction-functions.php");

function getMDIIdentifier()
{
	$sql="SELECT identifier_id FROM min_settings";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	{
	$today=date('dmY');	
	return $today.$resultArray[0][0];
	}
	}
	
function incrementMDIIdentifier()
{
	$sql="SELECT settings_id,identifier_id FROM min_settings";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	{
		$setting_id=$resultArray[0][0];
		$identifier=++$resultArray[0][1];
		
		$sql="UPDATE min_settings SET identifier_id=$identifier WHERE settings_id=$setting_id";
		dbQuery($sql);
	}
}	

function insertMDI($condition, $fault_explanation, $fault_id, $machine_id)
{
	
	try
	{
		
	if(checkForNumeric($fault_id, $machine_id, $condition) && validateForNull($fault_explanation))
	{
	$fault_explanation=clean_data($fault_explanation);
		
	$mdi_identifier=getMDIIdentifier();
	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];	
	$sql = "insert into min_MDI_form (mdi_condition, fault_explanation, fault_id, machine_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified, is_deleted, mdi_identifier) VALUES ('$condition', '$fault_explanation' , '$fault_id', $machine_id, $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address', 0, '$mdi_identifier') ";
	
	$result=dbQuery($sql);	
	incrementMDIIdentifier();
	sendAnEmail();
	sendanSMS();  
	
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

function AcknowledgeMDI($mdi_id)
{
	if(checkForNumeric($mdi_id) && $mdi_id>0)
	{
			$ip_address=$_SERVER['REMOTE_ADDR'];
			 $admin_id=$_SESSION['minexAdminSession']['admin_id'];
			
			
			$sql = "UPDATE min_MDI_form 
					SET acknowledged = 1, date_modified = NOW(), last_updated_by = $admin_id, ip_modified = '$ip_address' 
					WHERE mdi_id=$mdi_id";
			$result = dbQuery($sql); 
			
			return "success";
		
		}
	return "error";	
	
}

function listMDIForm()
{
		
	
	$sql="SELECT mdi_id, mdi_condition, fault_explanation, fault_name, min_MDI_form.machine_id, acknowledged,  machine_name, machine_code, min_MDI_form.created_by, min_MDI_form.date_added
	      FROM min_MDI_form, min_type_of_fault, min_machines
		  WHERE min_MDI_form.fault_id = min_type_of_fault.fault_id AND min_MDI_form.machine_id = min_machines.machine_id AND   is_deleted=0 ORDER BY min_MDI_form.date_added DESC";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}

function deleteMDIForm($id)
{
	try{
		
		if(checkForNumeric($id))
		{
		$sql="UPDATE min_MDI_form 
		      SET is_deleted=1 
			  WHERE mdi_id=$id";
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



function getMDIFormDetailsFromMachineId($machine_id)
{
	$sql="SELECT mdi_id, mdi_condition, fault_explanation, fault_name,acknowledged
	      FROM min_MDI_form, min_type_of_fault
		  WHERE min_MDI_form.machine_id=$machine_id AND min_MDI_form.fault_id=min_type_of_fault.fault_id AND is_deleted=0";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray;	
	
}

function getMDIFormDetailsFromFaultId($fault_id)
{
	$sql="SELECT mdi_id, mdi_condition, fault_explanation, fault_name, min_MDI_form.machine_id, acknowledged, machine_name, machine_code
	      FROM min_MDI_form, min_type_of_fault, min_machines
		  WHERE min_MDI_form.fault_id=min_type_of_fault.fault_id AND min_MDI_form.machine_id = min_machines.machine_id AND   is_deleted=0";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray;	
	
}

function getMDIFormDetailsFromMDIId($mdi_id)
{
	$sql="SELECT mdi_condition, fault_explanation, min_type_of_fault.fault_id, fault_name, min_MDI_form.machine_id,acknowledged, machine_name, machine_code, min_MDI_form.created_by, min_MDI_form.last_updated_by, min_MDI_form.date_added, min_MDI_form.date_modified, min_MDI_form.ip_created, min_MDI_form.ip_modified, admin_name, admin_id
	      FROM min_MDI_form, min_type_of_fault, min_machines, min_admin
		  WHERE min_MDI_form.fault_id=min_type_of_fault.fault_id AND min_MDI_form.machine_id = min_machines.machine_id AND min_MDI_form.mdi_id = $mdi_id AND min_admin.admin_id = min_MDI_form.created_by AND is_deleted=0";

   $result=dbQuery($sql);
   $resultArray=dbResultToArray($result);
   return $resultArray[0];	
	
}


function updateMDIForm($mdi_id, $mdi_condition, $fault_explanation, $fault_id, $machine_id)
{
	
			
			 
			$fault_explanation=clean_data($fault_explanation);
			$mdi_condition=clean_data($mdi_condition);
			$fault_id=clean_data($fault_id);
			$machine_id=clean_data($machine_id);
			
			if(validateForNull($fault_explanation) && checkForNumeric($mdi_id, $fault_id, $machine_id))
			{
				
				
			$ip_address=$_SERVER['REMOTE_ADDR'];
			 $admin_id=$_SESSION['minexAdminSession']['admin_id'];
			
			
			$sql = "UPDATE min_MDI_form 
					SET mdi_condition = $mdi_condition, fault_explanation = '$fault_explanation', fault_id = $fault_id, machine_id =                    $machine_id, date_modified = NOW(), last_updated_by = $admin_id, ip_modified = '$ip_address' 
					WHERE mdi_id=$mdi_id";
			$result = dbQuery($sql); 
			
			return "success";
			
			sendAnEmail();
	        sendanSMS();  
			
		}
		else
		{
			return "error";	
		}
	}


function getMDIStatus($mdi_id)
{
	if(checkForNumeric($mdi_id))
	{
			$mdi=getMDIFormDetailsFromMDIId($mdi_id);
			$mdi_acknowledged=$mdi['acknowledged'];
			if($mdi_acknowledged==0)
			return "NEW";
			else
			{
				if(getTotalActionsForMDIID($mdi_id)>0)
				return "IN PROGRESS";
				else
				return "ACKNOWLEDGED";
				}
		}
}
	

?>