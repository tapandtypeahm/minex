<?php
require_once('../lib/cg.php');
require_once('../lib/bd.php');
require_once('../lib/common.php');
require_once('../lib/takeAction-functions.php');

$department_id=$_GET['lid'];
getNewActionsForDepartment($_GET['lid']);
?>