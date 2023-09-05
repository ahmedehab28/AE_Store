//DECLARATIONS
const email = document.querySelector('#email');
const password = document.querySelector('#password');

const form = document.querySelector('form');

window.addEventListener('beforeunload', function(event) {
    document.querySelector('form').reset();
});


//EMAIL
email.addEventListener('focusout', () => {
    const emailRegex = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if (!emailRegex.test(email.value)) {
        const emailWarning = document.createElement('p');
        emailWarning.textContent = 'Invalid Email';
        emailWarning.classList.add('warning');
        emailWarning.classList.add('emailFormat');
        email.parentNode.insertBefore(emailWarning, email.nextSibling);
    }
});

email.addEventListener('focus', () => {
    const emailFormat = email.parentNode.querySelector('.emailFormat');

    if (emailFormat) {
        emailFormat.remove();
    }
});


// PASSWORD
password.addEventListener('focusout', () => {
    if (password.value.length == 0) {
        const passwordWarning = document.createElement('p');
        passwordWarning.textContent = 'Password cant be empty.';
        passwordWarning.classList.add('warning');
        passwordWarning.classList.add('passwordLength');
        password.parentNode.insertBefore(passwordWarning, password.nextSibling);
    }
});

password.addEventListener('focus', () => {
    const passwordLength = password.parentNode.querySelector('.passwordLength');

    if (passwordLength) {
        passwordLength.remove();
    }
});


//SUBMIT
form.addEventListener('submit', (event) => {
    const warnings = form.querySelectorAll('.warning');
    if (email.value.length == 0 || password.value.length == 0) {
        event.preventDefault();
        alert("Please Don't leave fields empty");
    } else if (warnings.length > 0) {
        event.preventDefault();
        alert('Please check your inputs');
    }

});
