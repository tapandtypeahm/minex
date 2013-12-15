
                jQuery("#txtname").validate({
                    expression: "if (VAL) return true; else return false;",
                    message: "Please enter the Company name"
                });
				 jQuery("#txtname").validate({
                     expression: "if (VAL.match(/^[a-zA-Z0-9&().:;,*@# ]+$/)) return true; else return false;",
                    message: "Only letters and dot(.) allowed!"
                });
                jQuery("#parent_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please select a parent"
                });
				 jQuery("#department_id").validate({
                    expression: "if (VAL && !isNaN(VAL) && VAL>-1) return true; else return false;",
                    message: "Please select a Department"
                });