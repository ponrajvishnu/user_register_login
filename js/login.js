localStorage.setItem('email','');

$('#login_form').submit(function(e){
    e.preventDefault();
    let form = $('#login_form');

    let email    = $("#email").val();
    let password = $("#password").val();

    if(email == ''){
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
    }else{
        $.ajax({
            type: "POST",
            url: 'ajaxFunction.php',
            data: {function:'userLogin',email: email, password: password},
            dataType: 'json',
            success: function(response){
                console.log(response);
                if(response.status == 1){
                    localStorage.setItem('email',email);
                    window.location.href = "profile.php?id="+response.user_id;
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