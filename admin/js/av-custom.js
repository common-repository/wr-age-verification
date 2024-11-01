jQuery(document).ready(function($) {
    jQuery(".editCountry").click(function(){
        var id =$(this).data('id');
        jQuery.ajax({
            url:ajax_url.ajaxurl,
            method:"POST",
            data:{
            	action:'edit_country',
            	id:id,
            },
            success:function(response){
                $(".modal-body").html(response.html);
                $("#exampleModal").modal('show'); 
            }
        })
    });

    jQuery("#status").click(function(){
        var id =$(this).data('id');
        var status = $("input[type='checkbox']").val();
        if(status == 1) {
            var status = 0;
        }else{
            var status = 1;
        }
        jQuery.ajax({
            url:ajax_url.ajaxurl,
            method:"POST",
            data:{
                action:'plugin_status',
                id:id,
                status:status,
            },
            success:function(response){
                console.log(response);
                alert(response.msg);
                jQuery("#status").attr('value', response.status);
            }
        })
    })

});

function isNumber(evt) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)) {
        return false;
    }
    return true;
}   

function fileValidation(id) {
    var logo = document.getElementById(id);
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    var filePath = logo.value;
    // Allowing file type
    if (!allowedExtensions.exec(filePath)) {
        document.getElementById(id+"_error").innerHTML = 'Invalid File Type,Only jpeg,jpg,png,gif allowed';
        logo.value = '';
        return false;
    }
}