var registerButton = document.getElementById('RegisterButton') ;
var clearButton = document.getElementById('ClearButton') ;
var completeForm = document.getElementById('registrationForm') ;
var nameForm = document.getElementById('name') ;
var phoneForm = document.getElementById('phone') ;
var passwordForm = document.getElementById('password') ;
var confirmPasswordForm = document.getElementById('confirmPassword') ;
var addressForm = document.getElementById('address') ;
var cityForm = document.getElementById('city') ;
var stateForm = document.getElementById('state') ;
var pincodeForm = document.getElementById('pincode') ;
var emailForm = document.getElementById('email') ;

registerButton.addEventListener('click',validate) ;
clearButton.addEventListener('click',resetForm) ;

function hasNumber(myString) {
    return /\d/.test(myString);
}

function InvalidEmail(mail) 
{
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/.test(mail))
    {
        return false;
    }
    return true;
}

function invalidPassword(inputtxt) 
{ 
    var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
    if(inputtxt.match(decimal)) return false;
    else return true;
} 
function validate(event){
    if(nameForm.value.length == 0 || hasNumber(nameForm.value)){
        nameForm.focus() ;
        nameForm.style.border = "3px solid Tomato";
        nameForm.placeholder = "Enter Valid Name";
        nameForm.value = "";
        setTimeout(function(){
            nameForm.style.border = "" ;
            nameForm.placeholder = "";
        },3000) ;
        return false;
    } 
    else if(phoneForm.value.length != 10 || isNaN(phoneForm.value)){
        phoneForm.focus() ;
        phoneForm.style.border = "3px solid Tomato";
        phoneForm.value = "";
        phoneForm.placeholder = "Enter Valid Phone No";
        setTimeout(function(){
            phoneForm.style.border = "" ;
            phoneForm.placeholder = "";

        },3000) ;
        return false;
    }
    else if(emailForm.value.length === 0 || InvalidEmail(emailForm.value)){
        emailForm.focus() ;
        emailForm.style.border = "3px solid Tomato";
        emailForm.placeholder = "Enter Valid Email ID";
        emailForm.value = "";
        setTimeout(function(){
            emailForm.style.border = "" ;
            emailForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(addressForm.value.length === 0 || !isNaN(addressForm.value)){
        addressForm.focus() ;
        addressForm.style.border = "3px solid Tomato";
        addressForm.placeholder = "Enter Valid Address";
        addressForm.value = "";
        setTimeout(function(){
            addressForm.style.border = "" ;
            addressForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(cityForm.value.length === 0 || hasNumber(cityForm.value)){
        cityForm.focus() ;
        cityForm.value = "";
        cityForm.style.border = "3px solid Tomato";
        cityForm.placeholder = "Enter Valid City";
        setTimeout(function(){
            cityForm.style.border = "" ;
            cityForm.placeholder = "";
        },3000) ;
        return false;    
    }
    else if(stateForm.value.length === 0 || hasNumber(stateForm.value)){
        stateForm.focus() ;
        stateForm.value = "";
        stateForm.style.border = "3px solid Tomato";
        stateForm.placeholder = "Enter Valid State";
        setTimeout(function(){
            stateForm.style.border = "" ;
            stateForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(pincodeForm.value.length != 6 || isNaN(pincodeForm.value)){
        pincodeForm.focus() ;
        pincodeForm.style.border = "3px solid Tomato";
        pincodeForm.placeholder = "Enter Valid Pincode";
        pincodeForm.value = "";
        setTimeout(function(){
            pincodeForm.style.border = "" ;
            pincodeForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(passwordForm.value.length === 0 || invalidPassword(passwordForm.value)){
        passwordForm.focus() ;
        passwordForm.style.border = "3px solid Tomato";
        passwordForm.placeholder = "Enter Valid Password";
        passwordForm.value = "";
        alert('Enter a password between 8 to 15 characters which contains at least one lowercase letter, one uppercase letter, one numeric digit, and one special character');
        setTimeout(function(){
            passwordForm.style.border = "" ;
            passwordForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(confirmPasswordForm.value.length === 0 || confirmPasswordForm.value!==passwordForm.value){
        confirmPasswordForm.focus() ;
        confirmPasswordForm.style.border = "3px solid Tomato";
        confirmPasswordForm.placeholder = "Re-enter Valid Password";
        confirmPasswordForm.value = "";
        setTimeout(function(){
            confirmPasswordForm.style.border = "" ;
            confirmPasswordForm.placeholder = "";
        },3000) ;
        return false;
    }
    else{
        console.log('Success');
    }
}

function resetForm(event)
{
    completeForm.reset() ;
}

window.onload = function(event){
    completeForm.reset() ;
}

function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}