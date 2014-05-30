function Register() {
    $.blockUI({message: $("#modal_dialog"), css: {width: '200px'}});
    $.post("ajax_register", {
        reg_email : $("#reg_email").val(),
        reg_pass : $("#reg_pass").val(),
        reg_pass2 : $("#reg_pass2").val(),
        reg_count : $("#reg_count").val()
    }, function(data){
        $.unblockUI();
        //console.log(data);
        if(data == 'wrong_format') {
            $(".reg_email_error").fadeTo(200, 0.1, function(){
                $(this).html('Неверный формат email').fadeTo(900,1);
            });
            $("#reg_email").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'email_exists') {
            $(".reg_email_error").fadeTo(200, 0.1, function() {
                $(this).html("Такой email уже существует").fadeTo(900,1);
            });
            $('#reg_email').css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'empty_email') {
            $(".reg_email_error").fadeTo(200, 0.1, function(){
                $(this).html("Поле не должно быть пустым").fadeTo(900,1);
            });
            $("#reg_email").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'empty_pass') {
            $(".reg_password1_error").fadeTo(200, 0.1, function() {
                $(this).html("Поле не должно быть пустым").fadeTo(900,1);
            });
            $("#reg_pass").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'pass_length') {
            $(".reg_password1_error").fadeTo(200, 0.1, function() {
                $(this).html("Недопустимая длина пароля").fadeTo(900,1);
            });
            $("#reg_pass").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'empty_pass2') {
            $(".reg_password2_error").fadeTo(200, 0.1, function() {
                $(this).html("Поле не должно быть пустым").fadeTo(900,1);
            });
            $("#reg_pass2").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'dont_match') {
            $(".reg_password2_error").fadeTo(200, 0.1, function() {
                $(this).html("Пароли не совпадают").fadeTo(900,1);
            });
            $("#reg_pass2").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'empty_count') {
            $(".reg_count_error").fadeTo(200, 0.1, function() {
                $(this).html("Поле не должно быть пустым").fadeTo(900,1);
            });
            $("#reg_count").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'not_int') {
            $(".reg_count_error").fadeTo(200, 0.1, function() {
                $(this).html("Поле должно быть целочисленным значением").fadeTo(900,1);
            });
            $("#reg_count").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } 
        window.location.reload(true);
        
        return false;
    });
}

function Recover() {
    $.blockUI({message: $("#modal_dialog"), css: {width: '200px'}});
    
    $.post("ajax_recover", {
        recover_email : $("#recover_email").val()
    }, function(data){
        $.unblockUI();
        //console.log(data);
        
        if(data == 'empty_recover_email') {
            $(".recover_error").fadeTo(200, 0.1, function(){
                $(this).html('Поле не должно быть пустым').fadeTo(900,1);
            });
            $("#recover_email").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'wrong_email_format') {
            $(".recover_error").fadeTo(200, 0.1, function(){
                $(this).html('Формат email неверный').fadeTo(900,1);
            });
            $("#recover_email").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        } else if(data == 'not_found') {
            $(".recover_error").fadeTo(200, 0.1, function(){
                $(this).html('Такой email не существует в БД').fadeTo(900,1);
            });
            $("#recover_email").css({"border" : "solid 1px red", "border-radius" : "2px"});
            
            return false;
        }
        
        window.location.reload(true);
        
        return false;
    });
}

