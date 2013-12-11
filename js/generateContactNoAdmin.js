// JavaScript Document
if($('.addContactbtnAdmin'))
{
	
$('.addContactbtnAdmin').click(function(e) {
	
    var newRowData=document.getElementById('addcontactTrGeneratedAdmin').innerHTML;
	
	var insertTable=document.getElementById('insertAdminTable');
	
	var newIndex=$('#addcontactTrAdmin').index();
	newIndex=newIndex+2;
	var newRow=insertTable.insertRow(newIndex);
	
	newRow.innerHTML=newRowData;
	
});
}

function deleteContactTr(elem){
	
	var parent1=elem.parentNode.parentNode.parentNode;
	parent1.innerHTML="";
	}
