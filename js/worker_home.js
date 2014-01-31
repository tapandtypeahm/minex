// JavaScript Document

function checkForNewActions(department_id)
{	
	var xmlhttp1;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp1 = new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp1.onreadystatechange=function()                        
  {
  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
    {
	
    var myarray=xmlhttp1.responseText;
	

    }
  }
  
  xmlhttp1.open('GET', "getDesignationFromDepartment.php?id="+department_id, true );    
  xmlhttp1.send(null);
	
}