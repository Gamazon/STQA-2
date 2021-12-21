var loginButton = document.getElementById('LoginButton') ;
var clearButton = document.getElementById('ClearButton') ;
var completeForm = document.getElementById('loginFormText') ;
var loginIDForm = document.getElementById('loginID') ;
var passwordForm = document.getElementById('password') ;
 
loginButton.addEventListener('click',validate) ;
clearButton.addEventListener('click',resetForm) ;

function invalidPassword(inputtxt) 
{ 
    var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
    if(inputtxt.match(decimal)) return false;
    else return true;
} 
function InvalidEmail(mail) 
{
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/.test(mail))
    {
        return false;
    }
    return true;
}

function validate(event){
    if((loginIDForm.value.length == 0 ) || (isNaN(loginIDForm.value) && InvalidEmail(loginIDForm.value))){
        loginIDForm.focus() ;
        loginIDForm.style.border = "3px solid Tomato";
        loginIDForm.placeholder = "Enter Valid LoginID";
        loginIDForm.value = "";
        setTimeout(function(){
            loginIDForm.style.border = "" ;
            loginIDForm.placeholder = "";
        },3000) ;
        return false;
    }
    else if(passwordForm.value.length === 0 || invalidPassword(passwordForm.value)){
        passwordForm.focus() ;
        passwordForm.style.border = "3px solid Tomato";
        passwordForm.placeholder = "Enter Valid Password";
        passwordForm.value = "";
        setTimeout(function(){
            passwordForm.style.border = "" ;
            passwordForm.placeholder = "";
        },3000) ;
        return false;
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