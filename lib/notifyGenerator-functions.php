<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");
require_once("lock-functions.php");
require_once("mdi-functions.php");

function insertNotifyGenerator($down_mode, $assigned_to, $job_started, $mdi_completed, $job_ended, $job_done, $mdi_id)
{
	
	try
	{
		
	if(!validateForNull($job_ended))	
	{
		$job_ended="1970-01-01 00:00:00";
	}
	if(checkForNumeric($mdi_id, $down_mode) && validateForNull($assigned_to, $job_started,$job_ended))
	{
	
	$job_started=str_replace("/","-",$job_started);
	$job_started=date('Y-m-d H:i:s',strtotime($job_started));
	
	$job_ended=str_replace("/","-",$job_ended);
	$job_ended=date('Y-m-d H:i:s',strtotime($job_ended));
	
		
	$assigned_to=clean_data($assigned_to);
	$job_started=clean_data($job_started);
	$job_ended=clean_data($job_ended);
	$job_done=clean_data($job_done);
		

	$admin_id=$_SESSION['minexAdminSession']['admin_id'];
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	$sql = "insert into min_notify_generator (machine_down_mode, assigned_to, job_started, mdi_completed, job_ended, work_done, mdi_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified) VALUES ('$down_mode', '$assigned_to' , '$job_started', '$mdi_completed', '$job_ended', '$job_done', $mdi_id, $admin_id, $admin_id, NOW(), NOW() , '$ip_address' , '$ip_address') ";

	$result=dbQuery($sql);	
	
	 AcknowledgeMDI($mdi_id);
	
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


function listNotifyGenerator()
{
		
	
	$sql="SELECT notify_id, machine_down_mode, assigned_to, job_started, job_ended, work_done, mdi_id, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified
	      FROM min_notify_generator";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray; 
		else
		return false;
	
}


function listNotifyGeneratorFromMDIId($m_id)
{
		
	
	$sql="SELECT notify_id, machine_down_mode, assigned_to, job_started, mdi_completed, mdi_completed_approval, job_ended, work_done, created_by, last_updated_by, date_added, date_modified, ip_created, ip_modified
	      FROM min_notify_generator
		  WHERE mdi_id=$m_id";
		$result=dbQuery($sql);	 
		$resultArray=dbResultToArray($result);
		if(dbNumRows($result)>0)
		return $resultArray[0]; 
		else
		return false;
	
}

function deleteNotifyGenerator($id)
{
	try{
		
		if(checkForNumeric($id))
		{
		$sql="DELETE FROM min_notify_generator 
			  WHERE notify_id=$id";
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

function updateNotifyGenerator($notify_id, $down_mode, $assigned_to, $job_started, $mdi_completed, $job_ended, $mdi_id, $work_done)
{
	
			$job_started=str_replace("/","-",$job_started);
			$job_started=date('Y-m-d H:i:s',strtotime($job_started));
	
			$job_ended=str_replace("/","-",$job_ended);
			$job_ended=date('Y-m-d H:i:s',strtotime($job_ended));
			 
			$assigned_to=clean_data($assigned_to);
			$job_started=clean_data($job_started);
			$job_ended=clean_data($job_ended);
			
			
	
			
			if(validateForNull($assigned_to) && checkForNumeric($down_mode, $mdi_completed, $mdi_id, $notify_id) && $mdi_id>0)
			{
			if($mdi_completed==0)
			{
				$job_ended="1970-01-01 00:00:00";
				$work_done='';
			}	
				
			$ip_address=$_SERVER['REMOTE_ADDR'];
			$admin_id=$_SESSION['minexAdminSession']['admin_id'];
			
			
			$sql = "UPDATE min_notify_generator 
					SET machine_down_mode = $down_mode, assigned_to = '$assigned_to', job_started = '$job_started', mdi_completed = '$mdi_completed', job_ended = '$job_ended', work_done = '$work_done', mdi_id='$mdi_id', date_modified = NOW(), ip_modified = '$ip_address', last_updated_by = $admin_id 
					WHERE notify_id=$notify_id";
			$result = dbQuery($sql); 
			
			return "success";
			
		}
		else
		{
			return "error";	
		}
	}
	
?>