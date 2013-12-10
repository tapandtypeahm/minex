<?php
$vehicle_reg_no="gj01kj1021";
if($vehicle_reg_no[2]=='0' || $vehicle_reg_no[2]==0)
			{
				$vehicle_reg_no[2]="";
				}
echo strtoupper($vehicle_reg_no);			
 ?>