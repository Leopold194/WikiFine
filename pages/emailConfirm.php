<?php session_start() ?>
<?php require 'templates/head.php'; ?>
<link rel='stylesheet' href='../css/templates/register.css'>
<link rel='stylesheet' href='../css/registers/emailConfirm.css'>
<?php require 'templates/navbar.php'; ?>

<div class="breadcrumb">
    <span class="line"></span>  
    <div class="circle1 circles activeCircle"><a class="breadcrumbCircle" href="register1.php"><p>1</p></a></div>
    <div class="circle2 circles"><a class="breadcrumbCircle" href="register2.php"><p>2</p></a></div>
    <div class="circle3 circles"><a class="breadcrumbCircle" href="register3.php"><p>3</p></a></div>
</div>

<div class="formTitle">
    <h1 class="title">Inscription</h1>
</div>

<div class="registerForm">
    <h2 class="formTitle">Vérification de l’adresse mail :</h2>
    <p class="formContent">Nous vous avons envoyé un e-mail à l'adresse <b>leopold.goudier@gmail.com</b><br><br>Pour activer votre compte WikiFine, vous devez renseigner dans le champ ci-dessous le code présent dans l’e-mail.</p>
    <div class="frame">
        <span class="forNumber forNumber0"></span>
        <span class="forNumber forNumber1"></span>
        <span class="forNumber forNumber2"></span>
        <span class="hyphen"></span>
        <span class="forNumber forNumber3"></span>
        <span class="forNumber forNumber4"></span>
        <span class="forNumber forNumber5"></span>
        <div class="inputDigitDiv">
            <div class="inputDigitLeft">
                <input type="text" class="inputDigit" maxlength="1" id="firstInput">
                <input type="text" class="inputDigit inputDigit1" maxlength="1" id="secondInput">
                <input type="text" class="inputDigit inputDigit2" maxlength="1" id="thirdInput">
            </div>
            <div class="inputDigitRight">
                <input type="text" class="inputDigit inputDigit3" maxlength="1" id="fourthInput">
                <input type="text" class="inputDigit inputDigit4" maxlength="1" id="fifthInput">
                <input type="text" class="inputDigit inputDigit5" maxlength="1" id="sixthInput">
            </div>
        </div>
    </div>
    <div class="submit field">
        <button type="submit">CONTINUER</button>
    </div> 
</div>
<script>
/*
const firstInput = document.getElementById('firstInput');
const secondtInput = document.getElementById('secondInput');
const thirdInput = document.getElementById('thirdInput');
const fourthInput = document.getElementById('fourthInput');
const fifthInput = document.getElementById('fifthInput');
const sixthInput = document.getElementById('sixthInput');

firstInput.addEventListener('keyup', function(event) {
  if (firstInput.value.length === 1) {
    secondInput.focus();
  }
});

secondInput.addEventListener('keyup', function(event) {
  if (secondInput.value.length === 1) {
    thirdInput.focus();
  }
});

thirdInput.addEventListener('keyup', function(event) {
  if (thirdInput.value.length === 1) {
    fourthInput.focus();
  }
});

fourthInput.addEventListener('keyup', function(event) {
  if (fourthInput.value.length === 1) {
    fifthInput.focus();
  }
});

fifthInput.addEventListener('keyup', function(event) {
  if (fifthInput.value.length === 1) {
    sixthInput.focus();
  }
});






secondInput.addEventListener('keyup', function(event) {
  if (secondInput.value.length === 0) {
    firstInput.focus();
  }
});

thirdInput.addEventListener('keyup', function(event) {
  if (thirdInput.value.length === 0) {
    secondInput.focus();
  }
});

fourthInput.addEventListener('keyup', function(event) {
  if (fourthInput.value.length === 0) {
    thirdInput.focus();
  }
});

fifthInput.addEventListener('keyup', function(event) {
  if (fifthInput.value.length === 0) {
    fourthInput.focus();
  }
});

sixthInput.addEventListener('keyup', function(event) {
  if (sixthInput.value.length === 0) {
    fifthInput.focus();
  }
});*/
/*
const inputs = document.querySelectorAll('input');

inputs.forEach((input, index) => {
    input.addEventListener('keyup', (event) => {
        if (input.value.length === 3 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        } 
    });
});

secondInput.addEventListener('keyup', function(event) {
  if (secondInput.value.length === 0) {
    firstInput.focus();
  }
});*/

/*
const inputs = [
    document.getElementById('firstInput'),
    document.getElementById('secondInput'),
    document.getElementById('thirdInput'),
    document.getElementById('fourthInput'),
    document.getElementById('fifthInput'),
    document.getElementById('sixthInput')
];

inputs.forEach((input, index) => {
    input.addEventListener('input', (event) => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        } else if (input.value.length === 0 && index > 0) {
            inputs[index - 1].focus();
        }
    });
});*/

const inputs = document.querySelectorAll('input.inputDigit');
for (let i = 0; i < inputs.length; i++) {
  inputs[i].addEventListener('keydown', function(event) {
    if (event.keyCode === 8 && this.value.length === 0) {
      if (i > 0) {
        inputs[i - 1].focus();
      }
    }
  });
  inputs[i].addEventListener('input', function(event) {
    if (this.value.length === 1) {
      if (i + 1 < inputs.length) {
        inputs[i + 1].focus();
      }
    }
  });
  inputs[i].tabIndex = i + 1;
}

</script>
</body>
</html>