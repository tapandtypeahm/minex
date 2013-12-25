
                jQuery("#department_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please select the Department!"
                });
				
				jQuery("#txtName").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Machine Name."
                });
				
				jQuery("#txtCode").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Machine Code."
                });