$(function (){
    jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
            else if (regexp.global)
                regexp.lastIndex = 0;
            return this.optional(element) || regexp.test(value);
        },
    );
    $("#phone").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            alert("Phone number allows digit only");
            return false;
        }
    });
})
function clientsubmit(){


    // $('.alert').setTimeout(function() {
    // }, 1000);

    $("#frmCheckout").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            username: {
                required: true,
                minlength: 3
            },
            email:{
                required:true,
                email: true
            },
            phone:{
                required:true,
                // matches: "[0-9]+",  // <-- no such method called "matches"!
                minlength:10,
                maxlength:11
            },
            user_type: {
                required: true,
            },
            team_name: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            confirm_password : {
                minlength : 6,
                equalTo : "#password"
            }
        },
        onfocusout: function(element) {
            this.element(element); // triggers validation
        },
        onkeyup: function(element, event) {
            this.element(element); // triggers validation
        },
        messages: {
            name: {
                required: "Please enter your Name",
                minlength: "Name requires at least 3 characters"
            },
            username: {
                required: "Please enter your User Name",
                minlength: "User Name requires at least 3 characters"
            },
            email: {
                required: "Please enter your Email",
                email: "Enter Valid Email"
            },
            phone:{
                required: "Enter your Phone number",
                // matches: "Phone number cannot be string",
                minlength: "Phone Number requires at least 10 characters",
                maxlength: "Phone Number cannot exceed 11 characters",
            },
            user_type: {
                required: "Select User Type",
            },
            team_name: {
                required: "Select Team Name",
            },
            password: {
                required: "password cannot be Empty",
                minlength: "password must be contain at least 6 characters"
            },
            confirm_password: {
                minlength: "Confirm password must be contain at least 6 characters",
                equalTo: "Confirm password must be same as password"
            },
        },
    });
}
