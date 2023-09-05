const fields = document.querySelectorAll('.field');

fields.forEach(function(field) {
    const input = field.querySelector('input');
    const label = field.querySelector('label');
    const span = field.querySelector('span');

    label.addEventListener('animationend', function() {
        if (label.classList.contains('fade-out')) {
            label.style.opacity = '0';
        } else if (label.classList.contains('appear')) {
            label.style.opacity = '1';
        }
    });

    span.addEventListener('animationend', function() {
        if (span.classList.contains('fade-out')) {
            span.style.opacity = '0';
        } else if (span.classList.contains('appear')) {
            span.style.opacity = '1';
        }
    });

    input.addEventListener('focus', function () {
        label.classList.remove('appear');
        label.classList.add('fade-out');
        span.classList.remove('fade-out');
        span.classList.add('appear');
    });

    input.addEventListener('focusout', function () {
        if (!input.value) {
            span.classList.remove('appear');
            span.classList.add('fade-out');
            label.classList.remove('fade-out');
            label.classList.add('appear');
        }
    });
});
