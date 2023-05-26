const eye0 = document.getElementById("eye0");
const eye1 = document.getElementById("eye1");
const passwordField = document.getElementById("pwd");
const passwordConfirmField = document.getElementById("pwdConfirm");

if(window.location.host == 'localhost'){
    filePrefix = '/wikiFine/';
}else{
    filePrefix = '/';
}

eye0.addEventListener("click", () => {
  if(eye0.classList.contains('open_eye')){
    eye0.src = `${filePrefix}/img/register/close_eye.png`;
    passwordField.type = "text";
    eye0.classList.add('close_eye');
    eye0.classList.remove('open_eye');
  }else{
    eye0.src = `${filePrefix}/img/register/open_eye.png`;
    passwordField.type = "password";
    eye0.classList.add('open_eye');
    eye0.classList.remove('close_eye');
  }
});

if(eye1 !== null) {
    eye1.addEventListener("click", () => {
    if(eye1.classList.contains('open_eye')){
        eye1.src = `${filePrefix}/img/register/close_eye.png`;
        passwordConfirmField.type = "text";
        eye1.classList.add('close_eye');
        eye1.classList.remove('open_eye');
    }else{
        eye1.src = `${filePrefix}/img/register/open_eye.png`;
        passwordConfirmField.type = "password";
        eye1.classList.add('open_eye');
        eye1.classList.remove('close_eye');
    }
    });
};