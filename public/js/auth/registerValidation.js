//DECLARATIONS
const userName = document.querySelector('#name');
const email = document.querySelector('#email');
const password = document.querySelector('#password');
const confirmPassword = document.querySelector('#confirm-password');
const inputFields = document.querySelectorAll('.field input');

inputFields.forEach(inputField => {
    inputField.addEventListener('focus', () => {
        const warnings = inputField.parentNode.querySelectorAll('.warning-response');
        warnings.forEach(warning => warning.remove());
    });
});

const form = document.querySelector('form');

window.addEventListener('beforeunload', function(event) {
    document.querySelector('form').reset();
});

// NAME
userName.addEventListener('focusout', () => {
    if (userName.value.length < 3) {
        const userNameWarning = document.createElement('p');
        userNameWarning.textContent = 'Please, enter 3 letters at least.';
        userNameWarning.classList.add('warning');
        userNameWarning.classList.add('userNameLength');
        userName.parentNode.insertBefore(userNameWarning, userName.nextSibling);
    }
    if (!/^[a-zA-Z\s]+$/.test(userName.value)) {
        const userNameWarning = document.createElement('p');
        userNameWarning.textContent = 'Add Chars Only';
        userNameWarning.classList.add('warning');
        userNameWarning.classList.add('userNameChar');
        userName.parentNode.insertBefore(userNameWarning, userName.nextSibling);
    }
    if (/\s{2,}/.test(userName.value)) {
        const userNameWarning = document.createElement('p');
        userNameWarning.textContent = 'Please enter only one space between words.';
        userNameWarning.classList.add('warning');
        userName.parentNode.insertBefore(userNameWarning, userName.nextSibling);
    }
});

userName.addEventListener('focus', () => {
    const warnings = userName.parentNode.querySelectorAll('.warning');
    warnings.forEach(warning => warning.remove());
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
    if (password.value.length < 8) {
        const passwordWarning = document.createElement('p');
        passwordWarning.textContent = 'Password should be at least 8 characters.';
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

// CONFIRM PASSWORD
confirmPassword.addEventListener('focusout', () => {
    if (confirmPassword.value !== password.value) {
        const confirmPasswordWarning = document.createElement('p');
        confirmPasswordWarning.textContent = 'Passwords do not match.';
        confirmPasswordWarning.classList.add('warning');
        confirmPasswordWarning.classList.add('confirmPasswordMatch');
        confirmPassword.parentNode.insertBefore(confirmPasswordWarning, confirmPassword.nextSibling);
    }
});

confirmPassword.addEventListener('focus', () => {
    const confirmPasswordMatch = confirmPassword.parentNode.querySelector('.confirmPasswordMatch');

    if (confirmPasswordMatch) {
        confirmPasswordMatch.remove();
    }
});


//SUBMIT
form.addEventListener('submit', (event) => {
    const warnings = form.querySelectorAll('.warning');
    if (userName.value.length == 0   || email.value.length == 0 || password.value.length == 0 || confirmPassword.value.length == 0) {
        event.preventDefault();
        alert("Please Don't leave fields empty");
    } else if (warnings.length > 0) {
        event.preventDefault();
        alert('Please check your inputs');
    }

});
