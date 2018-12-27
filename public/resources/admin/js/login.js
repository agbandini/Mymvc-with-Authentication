
$("#_loginBtn").click(function () {
    
    if ($("#_lgnFrm").valid()){
        $('#_icoLogin').attr('class', 'fa fa-spinner fa-spin');
        var email = $("#_email").val().trim();
        var password = $("#_password").val().trim();
        var remember = ($('#_remember').is(':checked') === true ? 1:0);
        if (email == '' || password == '') {
            $("#_boxAvviso").toggleClass("hide show").hide().fadeIn("slow");
            $("#_testoAvviso").text('Please, insert a valid mail/password combination!');
        } else {
            var encPwd = hex_sha512(password);
            $("#_hashpwd").val(encPwd);
            $('#_lgnFrm').submit(function(){
                $('input[name="password"]').prop('disabled', true);
            });
        }        
    }        
});

$(function () {
    
    $("#_lgnFrm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        errorPlacement: function (error, element) {
            error.insertBefore(element.parent());
        }
    });    
    
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
});