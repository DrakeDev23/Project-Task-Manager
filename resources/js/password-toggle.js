document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    const input = document.getElementById(toggle.dataset.passwordToggle);
    const eyeIcon = toggle.querySelector('[data-eye-icon]');
    const eyeOffIcon = toggle.querySelector('[data-eye-off-icon]');

    if (!input) return;

    toggle.addEventListener('click', () => {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        eyeIcon.classList.toggle('hidden', isPassword);
        eyeOffIcon.classList.toggle('hidden', !isPassword);
        toggle.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    });
});