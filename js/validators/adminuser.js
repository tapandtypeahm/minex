// JavaScript Document

jQuery("#txtName").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the bank name"
                });
jQuery("#txtName").validate({
                    expression: "if (VAL.match(/^[a-zA-Z ]+$/)) return true; else return false;",
                    message: "Only letters allowed!"
                });	
jQuery("#designation_id").validate({
                    expression: "if (!isNaN(VAL) && VAL>0) return true; else return false;",
                    message: "Please select designation!"
                });					
jQuery("#department_id").validate({
                    expression: "if (!isNaN(VAL) && VAL>0) return true; else return false;",
                    message: "Please select department!"
                });		
jQuery("#AdminContact").validate({
                    expression: "if (!isNaN(VAL) && VAL>0 && VAL.length==10) return true; else return false;",
                    message: "Please enter a valid mobile number!"
                });													
 jQuery("#txtEmail").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
                    message: "Please enter a valid Email id"
                });
												
jQuery("#txtUsername").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Username"
                });	
							
	jQuery("#txtUsername").validate({
                    expression: "if (VAL.match(/^[a-zA-Z0-9]+$/)) return true; else return false;",
                    message: "Only letters and digits allowed!"
                });		
				
	 jQuery("#txtPassword").validate({
                    expression: "if (VAL.length > 4 && VAL) return true; else return false;",
                    message: "Please enter a valid Password (5 digits or more)"
                });
                jQuery("#txtConfirmPassword").validate({
                    expression: "if ((VAL == jQuery('#txtPassword').val()) && VAL) return true; else return false;",
                    message: "Confirm password field doesn't match the password field"
                });			
				
function checkContactNo(contact,contactInput)
{
	
	if(contact=="" || contact==null)
		{
			$(contactInput).next().next().hide();
			$(contactInput).removeClass("ErrorField");
			res=res && true;
			
			}
		else if(contact.length>6 && contact.length<13 && $.isNumeric(contact))
		{
			
			$(contactInput).next().next().hide();
			$(contactInput).removeClass("ErrorField");
			res=res && true;
			
			}
		else
		{
			
			$(contactInput).next().next().show();
			$(contactInput).addClass("ErrorField");
			res=res && false;
			}	
	
	}
				
function addAdminUser()
{
	var res=true;
	var i=0;
	$( ".contact" ).each(function( index ) {
		var contact=$(this).val();
		if(contact=="" || contact==null)
		{
			$(this).next().next().hide();
			$(this).removeClass("ErrorField");
			res=res && true;
			
			}
		else if(contact.length>6 && contact.length<13 && $.isNumeric(contact))
		{
			$(this).next().next().hide();
			$(this).removeClass("ErrorField");
			res=res && true;
			
			}
		else
		{
			
			$(this).next().next().show();
			$(this).addClass("ErrorField");
			res=res && false;
			}	
	  
	});
	return res;
	}	