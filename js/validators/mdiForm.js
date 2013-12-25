
                jQuery("#machine_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please Select a Machine!"
                });
				
				 jQuery("#fault_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please Select the type of fault!"
                });
				
				
               