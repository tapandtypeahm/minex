<div class="insideCoreContent adminContentWrapper wrapper">
<h4 class="headingAlignment">Add a New Vehicle Dealer</h4>
<?php 
if(isset($_SESSION['ack']['msg']) && isset($_SESSION['ack']['type']))
{
	
	$msg=$_SESSION['ack']['msg'];
	$type=$_SESSION['ack']['type'];
	
	
		if($msg!=null && $msg!="" && $type>0)
		{
?>
<div class="alert no_print <?php if(isset($type) && $type>0 && $type<4) echo "alert-success"; else echo "alert-error" ?>">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php if(isset($type)  && $type>0 && $type<4) { ?> <strong>Success!</strong> <?php } else if(isset($type) && $type>3) { ?> <strong>Warning!</strong> <?php } ?> <?php echo $msg; ?>
</div>
<?php
		
		
		}
	if(isset($type) && $type>0)
		$_SESSION['ack']['type']=0;
	if($msg!="")
		$_SESSION['ack']['msg']=="";
}

?>
<form id="addAgencyForm" action="<?php echo $_SERVER['PHP_SELF'].'?action=add'; ?>" method="post" onsubmit="return checkCheckBox()">
<table id="dealerInsertTable" class="insertTableStyling no_print">

<tr>

<td class="firstColumnStyling">
Dealer Name<span class="requiredField">* </span> : 
</td>

<td>
<input type="text" name="name" id="name"/>
</td>
</tr>

<tr>
<td>
Address : 
</td>

<td>
<textarea name="address" cols="5" rows="6" id="address"></textarea>
</td>
</tr>


<tr>
<td>Company<span class="requiredField">* </span> : </td>
				<td>
					
                        <?php
                            $companies = listMachineCompanies();
							$i=1;
                            foreach($companies as $super)
                              {
                             ?>
                             <input name="company[]" type="checkbox" class="company" id="company_<?php echo $i; ?>" value="<?php echo $super['machine_company_id'] ?>"><label style="display:inline-block; top:3px; position:relative;padding-left:5px;" for="company_<?php echo $i++; ?>"> <?php echo $super['company_name']; ?>	</label><br />
                             <?php } ?>
                              
                         
                         
                            </td>
</tr>

<tr>

<td class="firstColumnStyling">
Remarks : 
</td>

<td>
<textarea type="text" name="remarks" id="remarks"></textarea>
</td>
</tr>

<tr>

<td class="firstColumnStyling">
Contact Person<span class="requiredField">* </span> : 
</td>

<td>
<input type="text" name="contact_person" id="contact_person"/>
</td>
</tr>

<tr>

<td class="firstColumnStyling">
Email : 
</td>

<td>
<input type="text" name="email" id="email"/>
</td>
</tr>




 <tr id="addcontactTrDealer">
                <td>
                Contact No<span class="requiredField">* </span> : 
                </td>
                
                <td id="addcontactTd">
                <input type="text" class="contact" id="customerContact" name="contactNo[]" placeholder="more than 6 Digits!" /> <span class="addContactSpan"><input type="button" title="add more contact no" value="+" class="btn btn-success addContactbtnDealer"/></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
                </td>
            </tr>

<!-- for regenreation purpose Please donot delete -->
            
            <tr id="addcontactTrGeneratedDealer">
            <td>
            Contact No : 
            </td>
            
            <td id="addcontactTd">
            <input type="text" class="contact" name="contactNo[]" onblur="checkContactNo(this.value,this)" placeholder="more than 6 Digits!" />  <span class="deleteContactSpan"><input type="button" value="-" title="delete this entry"  class="btn btn-danger deleteContactbtn" onclick="deleteContactTr(this)"/></span><span class="ValidationErrors contactNoError">Please enter a valid Phone No (only numbers)</span>
                </td>
            </td>
            </tr>
       
       
<!-- end for regenreation purpose -->

<tr>
<td></td>
<td>
<input type="submit" value="Add Dealer" class="btn btn-warning">
<a href="<?php echo WEB_ROOT ?>admin/settings/"><input type="button" value="back" class="btn btn-success" /></a>
</td>
</tr>
</table>
</form>
	
    <hr class="firstTableFinishing" />

<h4 class="headingAlignment">List of Dealers</h4>
    <div class="printBtnDiv no_print"><button class="printBtn btn"><i class="icon-print"></i> Print</button></div>
   	<div class="no_print">
    <table id="adminContentTable" class="adminContentTable">
    <thead>
    	<tr>
        	<th class="heading">No</th>
            <th class="heading">Dealer Name</th>
            <th class="heading">Address</th>
            <th class="heading">Company</th>
            <th class="heading">Contact Number</th>
            <th class="heading no_print btnCol" ></th>
            <th class="heading no_print btnCol" ></th>
            <th class="heading no_print btnCol"></th>
        </tr>
    </thead>
    <tbody>
        
        <?php
		$dealers=listMachineDealers();
		$no=0;
		foreach($dealers as $agencyDetails)
		{
		 ?>
         <tr class="resultRow">
        	<td><?php echo ++$no; ?>
            </td>
            <td><span  class="editLocationName" id="<?php echo $agencyDetails['dealer_id'] ?>"><?php echo $agencyDetails['dealer_name']; ?></span>
            </td>
            <td><span  class="editLocationName" id="<?php echo $agencyDetails['dealer_id'] ?>"><?php if($agencyDetails['dealer_address']=="" || $agencyDetails['dealer_address']==null) echo "NA"; else echo $agencyDetails['dealer_address']; ?></span>
            </td>
            
            
            <td><span  class="editLocationName" id="<?php echo $agencyDetails['dealer_id'] ?>"><?php   $companies=getMachineCompanyByDealerId($agencyDetails['dealer_id']); for($x=0;$x<count($companies);$x++){$comp=$companies[$x]; if($x==(count($companies)-1)){ echo $comp[0]; }else echo $comp[0]."  <br>";} ?></span>
            </td>
            
           
           <td><span  class="editLocationName" id="<?php echo $agencyDetails['dealer_id'] ?>"><?php   $contactNo=getDealerNumbersByDealerId($agencyDetails['dealer_id']); if(!isset($contactNo[0]) && !is_numeric($contactNo[0])) echo "NA"; else{ for($y=0;$y<count($contactNo);$y++) { $contact=$contactNo[$y]; if($y==(count($contactNo)-1)) echo $contact[0]; else echo $contact[0]." <br> ";}} ?></span>
            </td>
            
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=details&lid='.$agencyDetails['dealer_id'] ?>"><button title="View this entry" class="btn viewBtn"><span class="view">V</span></button></a>
            </td>
            <td class="no_print"> <a href="<?php echo $_SERVER['PHP_SELF'].'?view=edit&lid='.$agencyDetails['dealer_id'] ?>"><button title="Edit this entry" class="btn editBtn"><span class="delete">E</span></button></a>
            </td>
            <td class="no_print"> 
            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=delete&lid='.$agencyDetails['dealer_id'] ?>"><button title="Delete this entry" class="btn delBtn"><span class="delete">X</span></button></a>
            </td>
            
          
  
        </tr>
         <?php }?>
         </tbody>
    </table>
    </div>
     <table id="to_print" class="to_print adminContentTable"></table> 
</div>
<div class="clearfix"></div>