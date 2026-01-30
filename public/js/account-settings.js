/**
 * Account Settings Page Script
 * Handles form validation and alerts
 */

document.addEventListener('DOMContentLoaded', function() {
    // Close alert functionality
    const alertCloseButtons = document.querySelectorAll('.alert-close');
    alertCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            alert.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                alert.remove();
            }, 300);
        });
    });

    // Form validation
    const form = document.getElementById('accountSettingsForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateAccountSettingsForm(form)) {
                e.preventDefault();
            }
        });
    }

    // Password field watchers for form validation
    const currentPasswordField = form ? form.querySelector('input[name="current_password"]') : null;
    const newPasswordField = form ? form.querySelector('input[name="new_password"]') : null;
    const newPasswordConfirmField = form ? form.querySelector('input[name="new_password_confirmation"]') : null;

    if (newPasswordField && currentPasswordField) {
        // When user types new password, enable current password requirement
        newPasswordField.addEventListener('change', function() {
            if (this.value.trim()) {
                currentPasswordField.required = true;
                currentPasswordField.style.borderColor = '#3b82f6';
            } else {
                currentPasswordField.required = false;
                currentPasswordField.style.borderColor = '';
            }
        });
    }
});

function validateAccountSettingsForm(form) {
    const name = form.querySelector('input[name="name"]');
    const username = form.querySelector('input[name="username"]');
    const email = form.querySelector('input[name="email"]');
    const currentPassword = form.querySelector('input[name="current_password"]');
    const newPassword = form.querySelector('input[name="new_password"]');
    const newPasswordConfirm = form.querySelector('input[name="new_password_confirmation"]');

    // Reset previous error styles
    [name, username, email, currentPassword, newPassword, newPasswordConfirm].forEach(field => {
        if (field) {
            field.classList.remove('is-invalid');
        }
    });

    let isValid = true;

    // Validate name
    if (!name.value.trim()) {
        name.classList.add('is-invalid');
        isValid = false;
    }

    // Validate username
    if (!username.value.trim()) {
        username.classList.add('is-invalid');
        isValid = false;
    }

    // Validate email
    if (!email.value.trim() || !isValidEmail(email.value)) {
        email.classList.add('is-invalid');
        isValid = false;
    }

    // Validate password fields if new password is provided
    if (newPassword && newPassword.value.trim()) {
        // Current password is required
        if (!currentPassword || !currentPassword.value.trim()) {
            if (currentPassword) {
                currentPassword.classList.add('is-invalid');
            }
            isValid = false;
        }

        // New password must be at least 6 characters
        if (newPassword.value.length < 6) {
            newPassword.classList.add('is-invalid');
            isValid = false;
        }

        // Passwords must match
        if (newPassword.value !== newPasswordConfirm.value) {
            newPassword.classList.add('is-invalid');
            newPasswordConfirm.classList.add('is-invalid');
            isValid = false;
        }
    }

    return isValid;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
