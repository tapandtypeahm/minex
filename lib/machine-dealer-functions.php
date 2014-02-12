<?php 
require_once("cg.php");
require_once("location-functions.php");
require_once("common.php");
require_once("bd.php");

function listMachineDealers(){
	
	try
	{
		$sql="SELECT machine_dealer_id, dealer_name, dealer_address, contact_person, dealer_email
		  FROM min_machine_dealers
		  ORDER BY dealer_name";
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

function insertMachineDealer($dealer_name,$dealer_address,$city_id,$company_id,$contact_no,$contact_person,$email,$remarks){
	
	try
	{
		$dealer_name=clean_data($dealer_name);
		$contact_person=clean_data($contact_person);
		$email=clean_data($email);
		$dealer_name = ucwords(strtolower($dealer_name));
		$dealer_address=clean_data($dealer_address);
		
		if($dealer_name!=null && $dealer_name!='')
			{
			$admin_id=$_SESSION['minexAdminSession']['admin_id'];
			$sql="INSERT INTO min_machine_dealers
					(dealer_name, dealer_address, remarks, contact_person, dealer_email,  created_by, last_updated_by, date_added, date_modified)
					VALUES
					('$dealer_name','$dealer_address', '$remarks' , '$contact_person', '$email', $admin_id,$admin_id,NOW(),NOW())";
			dbQuery($sql);
			$machine_dealer_id=dbInsertId();
			if(is_array($company_id))
			{
				
				foreach($company_id as $comp)
				{
					
					insertCompanyToDealer($machine_dealer_id,$comp);
					}
				}
			else if(is_numeric($company_id))		
			insertCompanyToDealer($machine_dealer_id,$company_id);
			
			addMachineDealerContactNo($machine_dealer_id,$contact_no);
			return "success";
			}
		else if($duplcate)
		{
			$machine_dealer_id=$duplcate;
			if(is_array($company_id))
			{
				
				foreach($company_id as $comp)
				{
					
					insertCompanyToDealer($machine_dealer_id,$comp);
					}
				}
			else if(is_numeric($company_id))		
			insertCompanyToDealer($machine_dealer_id,$company_id);
			
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

function insertCompanyToDealer($machine_dealer_id,$company_id)
{
	
	if(checkForNumeric($machine_dealer_id,$company_id) && !checkForDuplicateCompanyToDealer($machine_dealer_id,$company_id))
	{
		
		
	$sql="INSERT INTO min_rel_company_dealer
	     (machine_company_id,machine_dealer_id)
		 VALUES
		 ($company_id,$machine_dealer_id)";
		 
	dbQuery($sql);	 
	}
	
	}	

function deleteDealersForCompany($machine_dealer_id,$company_id)
{
	
	if(checkForNumeric($machine_dealer_id) && !checkIfCompanyAndDealerIsInUse($machine_dealer_id,$company_id) )
	{
		$sql="DELETE FROM min_rel_company_dealer WHERE machine_dealer_id=$machine_dealer_id AND machine_company_id=$company_id";
		dbQuery($sql);
		}
	}	

function checkIfCompanyAndDealerIsInUse($machine_dealer_id,$company_id)
{
	
	$sql="SELECT machine_id FROM min_machine WHERE machine_machine_dealer_id=$machine_dealer_id AND machine_company_id=$company_id";
	$result=dbQuery($sql);
	
	if(dbNumRows($result)>0)
	{	
	return true;
	}
	else
	return false;
	
	}	

function checkForDuplicateCompanyToDealer($machine_dealer_id,$company_id)
{
	$sql="SELECT  company_dealer_id
	      FROM min_rel_company_dealer
	     WHERE machine_dealer_id=$machine_dealer_id
		 AND machine_company_id=$company_id";
	
	$result=dbQuery($sql);	
	$resultArray=dbResultToArray($result);
	
	if(dbNumRows($result)>0)
	return true;
	else
	return false;
	}
function deleteMachineDealer($id){
	
	try
	{
		if(checkForNumeric($id) && !checkIfDealerInUse($id))
		{
		$sql="DELETE FROM min_machine_dealers WHERE machine_dealer_id=$id";
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

function updateMachineDealer($id,$dealer_name,$dealer_address,$city_id,$company_id,$contact_no){
	
	try
	{
		$dealer_name=clean_data($dealer_name);
		$dealer_name = ucwords(strtolower($dealer_name));
		$dealer_address=clean_data($dealer_address);
		if($dealer_name!=null && $dealer_name!=''  && checkForNumeric($city_id,$id) && !checkForDuplicateDealer($dealer_name,$city_id,$id))
			{
			
			$admin_id=$_SESSION['minexAdminSession']['admin_id'];
			$sql="UPDATE min_machine_dealers
					SET dealer_name = '$dealer_name', dealer_address ='$dealer_address', city_id = $city_id, last_updated_by=$admin_id, date_modified=NOW()
					WHERE machine_dealer_id=$id";
					
			dbQuery($sql);
			$alCompanies=getMachineCompanyIDsByDealerId($id);
			foreach($alCompanies as $comp_id)
				{
				deleteDealersForCompany($id,$comp_id);
				}
			 if(is_array($company_id))
			{
				
				foreach($company_id as $comp)
				{
					insertCompanyToDealer($id,$comp);
					}
				}
			else if(is_numeric($company_id))
			{	
			insertCompanyToDealer($id,$company_id);
			}
			deleteAllContactNoMachineDealer($id);	
			addMachineDealerContactNo($id,$contact_no);
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

function getMachineDealerById($id){
	
	try
	{
		$sql="SELECT machine_dealer_id, dealer_name, dealer_address, min_city.city_id, city_name
		  FROM min_machine_dealers,min_city
		  WHERE min_machine_dealers.city_id=min_city.city_id
		  AND machine_dealer_id=$id";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0]; 
		else
		return false;
	}
	catch(Exception $e)
	{
	}
	
}

function getDealerNameFromDealerId($id)
{
try
	{
		$sql="SELECT  dealer_name
		  FROM min_machine_dealers
		  WHERE machine_dealer_id=$id";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0][0]; 
		else
		return false;
	}
	catch(Exception $e)
	{
	}	
}
	
function checkForDuplicateDealer($name,$city_id,$id=false)
{
	
	$sql="SELECT machine_dealer_id
		  FROM min_machine_dealers
		  WHERE dealer_name='$name'
		  AND city_id=$city_id";
		if($id==false)
		$sql=$sql."";
		else
		$sql=$sql." AND machine_dealer_id!=$id";		  
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0][0]; 
		else
		return false;
	
}

function addMachineDealerContactNo($machine_dealer_id,$contact_no)
{
	try
	{
		if(is_array($contact_no))
		{
			foreach($contact_no as $no)
			{
				if($no!="" && $no!=null && is_numeric($no))
				{
				insertContactNoMachineDealer($machine_dealer_id,$no); 
				}
			}
		}
		else
		{
			if($contact_no!="" && $contact_no!=null && is_numeric($contact_no))
				{
				insertContactNoMachineDealer($machine_dealer_id,$contact_no); 
				}
			
		}
	}
	catch(Exception $e)
	{
	}
}

function insertContactNoMachineDealer($id,$contact_no)
{
	try
	{
		if(checkForNumeric($id,$contact_no)==true && !checkForDuplicateContactNoDealer($id,$contact_no))
		{
		$sql="INSERT INTO min_machine_dealers_contact_no
				      (dealer_contact_no, machine_dealer_id)
					  VALUES
					  ('$contact_no', $id)";
				dbQuery($sql);	  
		}
	}
	catch(Exception $e)
	{}
	
	
}
function deleteContactNoMachineDealer($id)
{
	try
	{
		$sql="DELETE FROM min_machine_dealers_contact_no
			  WHERE dealer_contact_no_id=$id";
		dbQuery($sql);	  
	}
	catch(Exception $e)
	{}
	
	
	
	}
function deleteAllContactNoMachineDealer($id)
{
	try
	{
		$sql="DELETE FROM min_machine_dealers_contact_no
			  WHERE machine_dealer_id=$id";
		dbQuery($sql);
	}
	catch(Exception $e)
	{}
	
	
	
	}	
function updateContactNoMachineDealer($id,$contact_no)
{
	try
	{
		deleteAllContactNoMachineDealer($id);
		addMachineDealerContactNo($id,$contact_no);
	}
	catch(Exception $e)
	{}
	
	
	
	}	

function checkForDuplicateContactNoDealer($id,$contact_no)
{
	if(checkForNumeric($id,$contact_no))
	{
	$sql="SELECT dealer_contact_no_id
	      FROM min_machine_dealers_contact_no
		  WHERE dealer_contact_no='$contact_no'
		  AND machine_dealer_id=$id";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	return $resultArray[0][0];
	else
	return false;	
	}
	}	
function getMachineCompanyByDealerId($id)
{
	if(checkForNumeric($id))
	{
	$sql="SELECT company_name
	      FROM min_manufacturing_company, min_rel_company_dealer
		  WHERE min_manufacturing_company.machine_company_id=min_rel_company_dealer.machine_company_id
		  AND min_rel_company_dealer.machine_dealer_id=$id";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	return $resultArray;
	else
	return false;	
	}
	}
function getMachineCompanyIDsByDealerId($id)
{
	if(checkForNumeric($id))
	{
	$sql="SELECT min_machine_company.machine_company_id
	      FROM min_machine_company, min_rel_company_dealer
		  WHERE min_machine_company.machine_company_id=min_rel_company_dealer.machine_company_id
		  AND min_rel_company_dealer.machine_dealer_id=$id";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	$returnArray=array();
	if(dbNumRows($result)>0)
	{
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

	
function getDealerNumbersByDealerId($id)
{
	if(checkForNumeric($id))
	{
	$sql="SELECT dealer_contact_no
	      FROM min_machine_dealers_contact_no
		  WHERE min_machine_dealers_contact_no.machine_dealer_id=$id";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);
	if(dbNumRows($result)>0)
	return $resultArray;
	else
	return false;	
	}
	}	

function getDealersFromCompanyID($id)
{
	$sql="SELECT min_rel_company_dealer.machine_dealer_id,dealer_name
	      FROM min_rel_company_dealer, min_machine_dealers
		  WHERE machine_company_id=$id
		  AND min_rel_company_dealer.machine_dealer_id=min_machine_dealers.machine_dealer_id";
	$result=dbQuery($sql);
	$resultArray=dbResultToArray($result);	  
	if(dbNumRows($result)>0)
	return $resultArray;
	}	
function checkIfDealerInUse($id)
{
	$sql="SELECT machine_id FROM min_machine WHERE machine_machine_dealer_id=$id";
	$result=dbQuery($sql);
	if(dbNumRows($result)>0)
	return true;
	else
	return false;
	
	}

?>