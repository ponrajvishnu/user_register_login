localStorage.setItem('email','');

$('#register_form').submit(function(e){
    e.preventDefault();
    let form = $('#register_form');

    let first_name       = $("#first_name").val();
    let last_name        = $("#last_name").val();
    let email            = $("#email").val();
    let password         = $("#password").val();
    let confirm_password = $("#confirm_password").val();

    if(first_name == ''){
        $(".fname-err").html('Please enter first name');
        $("#first_name").focus();
        return false;
    }else if(last_name == ''){
        $(".lname-err").html('Please enter last name');
        $("#last_name").focus();
        return false;
    }else if(email == ''){
        $(".email-err").html('Please enter email');
        $("#email").focus();
        return false;
    }else if(!validateEmail(email)){
        $(".email-err").html('Please enter valid email address');
        $("#email").focus();
        return false;
    }else if(password == ''){
        $(".pwd-err").html('Please enter password');
        $("#password").focus();
        return false;
    }else if(confirm_password == ''){
        $(".cpwd-err").html('Please enter confirm password');
        $("#confirm_password").focus();
        return false;
    }else if(password != confirm_password){
        $(".cpwd-err").html('Password does not matched');
        $("#confirm_password").focus();
        return false;
    }else{
        $.ajax({
            type: "POST",
            url: 'ajaxFunction.php',
            data: {function:'userRegistration',first_name: first_name, last_name: last_name, email: email, password: password},
            dataType: 'json',
            success: function(response){
                console.log(response);
                form[0].reset();
                $(".err").hide();
                if(response.status == 1){
                    alert(response.msg);
                }else if(response.status == 2){
                    alert(response.msg);
                }else{
                    alert(response.msg);
                }
            }
        })
    }
})


function validateEmail($email) {
    let emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}