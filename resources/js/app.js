import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('button-toggle');
    const navbarNav = document.getElementById('navbarNav');

    toggleButton.addEventListener('click', function () {
        if (navbarNav.style.display === 'block') {
            navbarNav.style.display = 'none';
        } else {
            navbarNav.style.display = 'block';
        }
    });
});

document.getElementById('logout-link').addEventListener('click', function (event) {
    event.preventDefault();

    const logoutUrl = this.dataset.logoutUrl;
    const csrfToken = this.dataset.csrfToken;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = logoutUrl;

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;

    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
});
