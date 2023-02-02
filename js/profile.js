$(document).ready(function(){

    let sessionEmail = localStorage.getItem('email');
    let email = $("#email").val();

    if(sessionEmail != email){
        window.location.href = "../index.html";
    }

    $('#user_profile').submit(function(e){
        e.preventDefault();
        let form = $('#user_profile');
    
        let email   = $("#email").val();
        let mobile  = $("#mobile").val();
        let dob     = $("#dob").val();
        let age     = $("#age").val();
        let gender  = $("#gender").val();
        let address = $("#address").val();
    
        $.ajax({
            type: "POST",
            url: 'ajaxFunction.php',
            data: {function:'userProfile',email: email,mobile: mobile, dob: dob, age: age, gender: gender,address: address},
            dataType: 'json',
            success: function(response){
                console.log(response);
                location.reload();
            }
        })
    })
})
