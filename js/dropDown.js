// JavaScript Document

function createDropDownDesignationDepartment(department_id)
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
	
    var myarray=eval(xmlhttp1.responseText);
	
// Before adding new we must remove previously loaded elements

removeData("designation_id");

var plsOptn = document.createElement("OPTION");

plsOptn.value = -1;
plsOptn.text = "--Please Select--";

document.getElementById("designation_id").options.add(plsOptn);

for (var i=0; i<myarray.length; i++)
{
	
var optn = document.createElement("OPTION");

optn.value = myarray[i];
optn.text = myarray[++i];

document.getElementById("designation_id").options.add(optn);

} 
    }
  }
  
  xmlhttp1.open('GET', "getDesignationFromDepartment.php?id="+department_id, true );    
  xmlhttp1.send(null);
	
}

function createDropDownAreaCustomer(city_id)
{
	
	createDropDown("getAreaFromCity.php?id="+city_id,"customer_area_id",null);
	}	
	
function createDropDownAreaReports(city_id)
{

	createDropDownCity_area("../../getAreaFromCity.php?id="+city_id,"city_area1",null);
	
	
	}		

function createDropDownMergeArea(city_id)
{

	createDropDownCity_area("../../getAreaFromCity.php?id="+city_id,"city_area1",null);
	
	
	}			

function createDropDownAreaGuarantor(city_id)
{
	
	createDropDown("getAreaFromCity.php?id="+city_id,"guarantor_area_id",null);
	
	}		

function createDropDown(url,id,removeArray)  
{

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function()                        
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    var myarray=eval(xmlhttp.responseText);
	
// Before adding new we must remove previously loaded elements

removeData(id);
if(removeArray!=null)
{
for(var i=0;i<removeArray.length;i++)
{
	removeData(removeArray[i]);
	}
}

var plsOptn = document.createElement("OPTION");

plsOptn.value = -1;
plsOptn.text = "--Please Select--";

document.getElementById(id).options.add(plsOptn);

for (var i=0; i<myarray.length; i++)
{
	
var optn = document.createElement("OPTION");

optn.value = myarray[i];
optn.text = myarray[++i];

document.getElementById(id).options.add(optn);

}

    }
  }
  
  xmlhttp.open('GET', url, true );    
  xmlhttp.send(null);

}


function createDropDownCity_area(url,id,removeArray)  
{

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function()                        
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
    var myarray=eval(xmlhttp.responseText);
	
// Before adding new we must remove previously loaded elements

removeData(id);
if(removeArray!=null)
{
for(var i=0;i<removeArray.length;i++)
{
	removeData(removeArray[i]);
	}
}

var plsOptn = document.createElement("OPTION");

plsOptn.value = -1;
plsOptn.text = "--Please Select--";

document.getElementById(id).options.add(plsOptn);

for (var i=0; i<myarray.length; i++)
{
	
var optn = document.createElement("OPTION");

optn.value = myarray[i];
optn.text = myarray[++i];

document.getElementById(id).options.add(optn);

}
 $('.selectpicker').selectpicker('refresh');
    }
  }
  
  xmlhttp.open('GET', url, true );    
  xmlhttp.send(null);

}

function createDropDown2(url,id,removeArray)  
{

var xmlhttp2;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp2 = new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp2.onreadystatechange=function()                        
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
	
    var myarray=eval(xmlhttp2.responseText);
	
// Before adding new we must remove previously loaded elements

removeData(id);
if(removeArray!=null)
{
for(var i=0;i<removeArray.length;i++)
{
	removeData(removeArray[i]);
	}
}

var plsOptn = document.createElement("OPTION");

plsOptn.value = -1;
plsOptn.text = "--Please Select--";

document.getElementById(id).options.add(plsOptn);

for (var i=0; i<myarray.length; i++)
{
	
var optn = document.createElement("OPTION");

optn.value = myarray[i];
optn.text = myarray[++i];

document.getElementById(id).options.add(optn);

} 
    }
  }
  
  xmlhttp2.open('GET', url, true );    
  xmlhttp2.send(null);

}

function removeData(id){
	
	for(j=document.getElementById(id).options.length-1;j>=0;j--)
	{	
	document.getElementById(id).remove(j);
	}
	
}