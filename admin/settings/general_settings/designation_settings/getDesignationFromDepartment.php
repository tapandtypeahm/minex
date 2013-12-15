<?php
require_once('../../../../lib/cg.php');
require_once('../../../../lib/bd.php');
require_once('../../../../lib/department-functions.php');
require_once('../../../../lib/designation-functions.php');


if(isset($_GET['id'])){
$id=$_GET['id'];
$result=array();

$branch=getSmallestDesignationForDepartment($id);
if($branch!=false)
{
$str="";
$str=$str . "\"$branch[designation_id]\"".",". "\"$branch[designation_name]\"".",";
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string
echo "new Array($str)";
}
else
{
	$str="";
$str=$str . "\"0\"".",". "\"No Parent\"".",";
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string
echo "new Array($str)";
	
	
	}
}
?>