const menu      = document.querySelector('#mobile-menu');
const menuLinks = document.querySelector('.nav__menu');

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
})

$(".nav__links").mouseenter(function() {
    $('#audio')[0].play()
});

//Modal Items register
const modalRegister         = document.getElementById('email-modal-register');
const openBtn               = document.querySelector('#main__register');
const openViaLogin          = document.querySelector('#openViaLogin');
const closeBtn              = document.querySelector('.close-btn');

//Click events Modal
openBtn.addEventListener('click', () => {
    modalRegister.style.display = 'block';
});

openViaLogin.addEventListener('click', () => {
    modalLogin.style.display = 'none';
    modalRegister.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    modalRegister.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if(e.target === modalRegister) {
        modalRegister.style.display = 'none';
    }
});

//Modall Items login
const modalLogin        = document.getElementById('email-modal-login');
const openBtn2          = document.querySelector('#login_btn');
const openViaRegister   = document.querySelector('#openViaRegister');
const closeBtn2         = document.querySelector('.close-btn2');

//Click events Modall
openBtn2.addEventListener('click', () => {
    modalLogin.style.display = 'block';
});

openViaRegister.addEventListener('click', () => {
    modalRegister.style.display = 'none';
    modalLogin.style.display = 'block';
});

closeBtn2.addEventListener('click', () => {
    modalLogin.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if(e.target === modalLogin) {
        modalLogin.style.display = 'none';
    }
});

//Form Validation
const form              = document.getElementById('form');
const firstname         = document.getElementById('firstname');
const lastname          = document.getElementById('lastname');
const telephone         = document.getElementById('telephone');
const email             = document.getElementById('email');
const password          = document.getElementById('password');
const passwordRepeat    = document.getElementById('passwordRepeat');
const street            = document.getElementById('street');
const town              = document.getElementById('postalcode');

//Show Error
function showError(input, message) {
    const formValidation = input.parentElement;
    formValidation.className = 'form-validation error';

    const errorMessage = formValidation.querySelector('p');
    errorMessage.innerText = message;
}

//Show Valid
function showValid(input) {
    const formValidation = input.parentElement;
    formValidation.className = 'form-validation valid';
}

//Check required fields
function checkRequired(inputArray) {
    form.addEventListener('touchstart', () => {
        inputArray.forEach(function(input) {
            if(input.value.trim() === '') {
                showError(input, `${getFieldName(input)} is required`);
            } else {
                showValid(input);
            }
        });
    })  
}

//Check input length
function checkLength(input, min, max) {
    if(input.value.length < min) {
        showError(input, `${getFieldName(input)} muss mindestens ${min} Zeichen enthalten`);
    } else if (input.value.length > max) {
        showError(input, `${getFieldName(input)} muss weniger als ${max} Zeichen enthalten`);
    } else {
        showValid(input);
    }
}

//check passwords match
function passwordMatch(input1, input2) {
    if(input1.value !== input2.value) {
        showError(input2, 'Passwörter stimmen nicht überein');
    }
}

//Get fieldname
function getFieldName(input) {
    return input.name.charAt(0).toUpperCase() + input.name.slice(1);
}

//Event Listeners
form.addEventListener('input', () => {

    checkRequired([firstname, lastname, telephone, email, password, passwordRepeat, street, town]);
    checkLength(firstname, 3, 30);
    checkLength(lastname, 3, 30);
    checkLength(password, 6, 25);
    checkLength(passwordRepeat, 6, 25);
    passwordMatch(password, passwordRepeat);

})