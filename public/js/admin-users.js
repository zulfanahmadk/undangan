let currentDeleteForm = null;

// Add User Modal
function openAddUserModal() {
    const modal = document.getElementById('addUserModal');
    if (modal) {
        modal.classList.add('active');
        modal.querySelector('.form-input').focus();
    }
}

function closeAddUserModal() {
    const modal = document.getElementById('addUserModal');
    if (modal) {
        modal.classList.remove('active');
        document.getElementById('addUserForm').reset();
    }
}

function handleAddUserFormSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('addUserForm');
    form.submit();
}

// Edit User Modal
function openEditUserModal(userId, userName, userEmail, roleId) {
    const modal = document.getElementById('editUserModal');
    if (modal) {
        document.getElementById('editUserName').value = userName;
        document.getElementById('editUserEmail').value = userEmail;
        document.getElementById('editUserRole').value = roleId || 2; // Default to user role
        document.getElementById('editUserForm').action = `/admin/users/${userId}`;
        modal.classList.add('active');
        document.getElementById('editUserName').focus();
    }
}

function closeEditUserModal() {
    const modal = document.getElementById('editUserModal');
    if (modal) {
        modal.classList.remove('active');
        document.getElementById('editUserForm').reset();
    }
}

function handleEditUserFormSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('editUserForm');
    form.submit();
}

// Delete User Confirmation
document.addEventListener('DOMContentLoaded', function() {
    const deleteFormElements = document.querySelectorAll('.delete-form');
    deleteFormElements.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            currentDeleteForm = form;
            const userName = form.getAttribute('data-user-name');
            const confirmationModal = document.getElementById('deleteUserConfirmationModal');
            if (confirmationModal) {
                confirmationModal.classList.add('active');
            }
        });
    });

    // Close modals on background click
    const modals = document.querySelectorAll('.modal, .confirmation-modal');
    modals.forEach(function(modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    });

    // Alert close buttons
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                alert.style.display = 'none';
            });
        }
    });

    setTimeout(function() {
        alerts.forEach(function(alert) {
            if (alert.style.display !== 'none') {
                alert.style.display = 'none';
            }
        });
    }, 5000);
});

function closeDeleteUserConfirmation() {
    const modal = document.getElementById('deleteUserConfirmationModal');
    if (modal) {
        modal.classList.remove('active');
    }
    currentDeleteForm = null;
}

function confirmDeleteUser() {
    if (currentDeleteForm) {
        currentDeleteForm.submit();
    }
}
