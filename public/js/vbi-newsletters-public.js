			jQuery(document).ready(function(e){
				
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
		        		if(checkSpecificDomain(value,emails[i])){
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
		        		if(checkSpecificDomain(value,emails[i])){
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

		       var validate_json = {
    	            rules: {
    	            	
    	                "email": {
    	                    required: true,
    	                    validEmail: true,
    						// CheckFreeISPAccount: true,
    						// CheckConsultantsAccount: true
    	                }
    	            },
                    submitHandler: function (form) {

                    	var action_form = jQuery(this);	
                    	var type = action_form[0].currentForm.firstElementChild.value;
						var em = jQuery("input#"+type+"_email").val();
						var pn = jQuery("input#"+type+"_pagename").val();
						var pu = jQuery("input#"+type+"_pageurl").val();
						var hs = jQuery("input#"+type+"_hubutk").val();
						var ip = jQuery("input#"+type+"_ipaddr").val();
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

						jQuery('form#'+type+'_newsletter_reg').block(block_config);
					    jQuery.post(newsletters_vars._newsletters_ajax_url, data, function(response){
	                    	if(response.hubspot == "204"){
	                    		jQuery('form#'+type+'_newsletter_reg p.message').html('Form Submitted Successfully.');
	                    	}else if(response.error == 'inemail'){
	                    		jQuery('form#'+type+'_newsletter_reg p.message').html('Please enter a valid business email.');
	                    	}else{
	                    		jQuery('form#'+type+'_newsletter_reg p.message').html('Submission Failed. Please try Again.');
	                    	}

	                    	jQuery('form#'+type+'_newsletter_reg').unblock();

	                    });		
                    }
                };

    			jQuery('#widget_newsletter_reg').validate(validate_json);
    			jQuery('#shortcode_newsletter_reg').validate(validate_json);
			});

