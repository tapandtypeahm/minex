
                jQuery("#department_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please select the Department!"
                });
				
				
				
				jQuery("#jobDescription").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Job Description."
                });