// JavaScript Document
if($('.addContactbtnDealer'))
{
$('.addContactbtnDealer').click(function(e) {
	
    var newRowData=document.getElementById('addcontactTrGeneratedDealer').innerHTML;
	var insertTable=document.getElementById('dealerInsertTable');
	var newIndex=$('#addcontactTrDealer').index();
	newIndex=newIndex+2;
	var newRow=insertTable.insertRow(newIndex);
	newRow.innerHTML=newRowData;
});
}

function deleteContactTr(elem){
	
	var parent1=elem.parentNode.parentNode.parentNode;
	parent1.innerHTML="";
	}
