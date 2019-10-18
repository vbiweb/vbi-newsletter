			jQuery(document).ready(function(e){
						console.log(newsletters_vars._newsletters_ajax_url);

				function checkSpecificDomain(email,domain){
				    var at_index = email.indexOf('@');
				    if(at_index !== -1){
				    var email_domain = email.substr(at_index+1);
				    var lower_email_domain = email_domain.toLowerCase();
				        if(lower_email_domain == domain){
				        return true;
				        }else{
				        return false;
				        }
				    }else{
				        return false;
				    }
				}

				/**************************************************/

	    		jQuery.validator.addMethod("validEmail", function (value, element) {
					var atpos = value.indexOf("@");
					var dotpos = value.lastIndexOf(".");
					if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= value.length) {
	    		        return false;
	    		    } else {
	    		        return true;
	    		    }
	    		}, "Please enter valid email");

	    		/**************************************************/

		        jQuery.validator.addMethod("CheckFreeISPAccount", function (value, element) {
		        	var free_isp_emails = '';
		        	var emails = free_isp_emails.split(', ');
		        	is_blocked = false;

		        	for(i = 0; i< emails.length; i++){
		        		if(checkSpecificDomain(jQuery('#email').val(),emails[i])){
		        			is_blocked = true;
		        			break;
		        		}
		        	}

		        	if(is_blocked)
		        		return false;
		        	else
		        		return true;
	       		}, "...");

	       		/**************************************************/

		        jQuery.validator.addMethod("CheckConsultantsAccount", function (value, element) {
		        	var consultant_emails = '';
		        	var emails = consultant_emails.split(', ');
		        	is_blocked = false;

		        	for(i = 0; i< emails.length; i++){
		        		if(checkSpecificDomain(jQuery('#email').val(),emails[i])){
		        			is_blocked = true;
		        			break;
		        		}
		        	}

		        	if(is_blocked)
		        		return false;
		        	else
		        		return true;
	       		}, "...");

		        /**************************************************/

    			jQuery('form#newsletter_reg').validate({
    	            rules: {
    	            	
    	                "email": {
    	                    required: true,
    	                    validEmail: true,
    						// CheckFreeISPAccount: true,
    						// CheckConsultantsAccount: true
    	                }
    	            },
                    submitHandler: function () {
					
						var em = jQuery("input#email").val();
					
						var pn = jQuery("input#pagename").val();
						var pu = jQuery("input#pageurl").val();
						var hs = jQuery("input#hubutk").val();
						var ip = jQuery("input#ipaddr").val();

						var data = {
						  	action: 'newsletters_submission',
						 	email: em,
						  	pagename: pn,
						  	pageurl: pu,
						  	hubspotutk: hs,
						  	ipaddr: ip
						  	
						};

						var block_config = {
							message:'<h3>Just a moment...</h3>',
							css: { 
						        padding:        '20px 0px', 
						        margin:         0, 
						        width:          '80%', 
						        top:            '40%', 
						        left:           '10%', 
						        textAlign:      'center', 
						        color:          '#fff', 
						        border:         'none', 
						        backgroundColor:'rgba(255,255,255,0)', 
						        cursor:         'wait' 
						    },
						    overlayCSS:  { 
					            backgroundColor: '#fff', 
					            opacity:         0.6, 
					            cursor:          'wait' 
					        },
						};

						jQuery('form#newsletter_reg').block(block_config);
						console.log(newsletters_vars._newsletters_ajax_url);
					    jQuery.post(newsletters_vars._newsletters_ajax_url, data, function(response){
	                    	console.log(response);
	                    	if(response.hubspot == "204"){
	                    		jQuery('form#newsletter_reg p.message').html('Form Submitted Successfully.');
	                    	}else if(response.error == 'inemail'){
	                    		jQuery('form#newsletter_reg p.message').html('Please enter a valid business email.');
	                    	}else{
	                    		jQuery('form#newsletter_reg p.message').html('Submission Failed. Please try Again.');
	                    	}

	                    	jQuery('form#newsletter_reg').unblock();

	                    });		
                    }
                });
			});

