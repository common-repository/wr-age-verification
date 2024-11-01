function get_state() {
	var id = document.getElementById("country").value;
	jQuery.ajax({
		url: ajax_url.ajaxurl,
		type:"POST",
		data: {
			action:'get_state',
			id:id
		},
		success: function(data){
			var myObj = jQuery.parseJSON(data);
			if (myObj.type == 'success') {
				jQuery('select[name="state"]').empty();
				jQuery('select[name="state"]').append('<option value="'+ myObj.id +'">'+ myObj.name +'</option>');
				jQuery('#age').empty();
				jQuery('#age').append(myObj.age);
				jQuery('#hidden').val(myObj.age);
			}
			console.log(data);
		},
		error:function(request, error) {
			console.log(error);
		}
	});
}
function get_minimum_age() {
	var id = document.getElementById("country").value;
	if (id == '') {
		jQuery('#age').html(default_age);
		jQuery('#hidden').val(default_age);
	}else{
		jQuery.ajax({
			url: ajax_url.ajaxurl,
			type:"POST",
			data: {
				action:'get_state',
				id:id
			},
			success: function(myObj){
				if (myObj.type == 'success') {
					jQuery('#age').empty();
					jQuery('#age').append(myObj.age);
					jQuery('#hidden').val(myObj.age);
				}
				console.log(myObj);
			},
			error:function(request, error) {
				console.log(error);
			}
		});
	}
}
jQuery(function() {
	jQuery('#verify_form').on('submit', function() {
		var age = jQuery('#hidden').val();
		if(age == '') {
		   var age = 21;
		}
		var day = jQuery('#day').val();
		var month = jQuery('#month').val();
		var year = jQuery('#year').val();
		var birthday = month+'/'+day+'/'+year;
		let dt1 = new Date(birthday);
		let dt2 = new Date();
		let yearsDiff =  dt2.getFullYear() - dt1.getFullYear();
		if(yearsDiff > age ) {
			var cookies = "age_verification_plugin";
			setCookie("user_age_data", window.btoa(cookies), 1);
			jQuery('#age_v').hide();
		}else{
			jQuery('#wr_error').append('You are not eligible for access this site');
			setTimeout(function(){ 
				jQuery('#wr_error').hide();
				document.getElementById("verify_form").reset();
			}, 2000);
		}   
	});
	function setCookie(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires=" + d.toGMTString();
	    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function getCookie(cname) {
	    var name = cname + "=";
	    var decodedCookie = decodeURIComponent(document.cookie);
	    var ca = decodedCookie.split(';');
	    for(var i = 0; i < ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0) == ' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return c.substring(name.length, c.length);
	        }
	    }
	    return "";
	}
});
function non_verified(){
	window.close();
}
function verifiedAge(){
	var cname = "user_age_data";
	var cvalue = window.btoa('age_verification_plugin');
	var d = new Date();
	d.setTime(d.getTime() + (1*24*60*60*1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";	
	jQuery('#age_v').hide();
}