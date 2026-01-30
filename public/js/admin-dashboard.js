/**
 * Admin Dashboard - Guest Management
 */

let pendingDeleteForm = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeModals();
    initializeSearch();
    initializeAlerts();
    initializeDeleteButtons();
    initializeWhatsAppInputs();
});

/**
 * Initialize modal functionality
 */
function initializeModals() {
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const addModal = document.getElementById('addModal');
        const editModal = document.getElementById('editModal');

        if (event.target === addModal) {
            closeAddModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    });
}

/**
 * Open add guest modal
 */
function openAddModal() {
    const modal = document.getElementById('addModal');
    if (modal) {
        modal.classList.add('active');
    }
}

/**
 * Close add guest modal
 */
function closeAddModal() {
    const modal = document.getElementById('addModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

/**
 * Open edit guest modal
 */
function openEditModal(guestId, guestName, guestWhatsapp) {
    const modal = document.getElementById('editModal');
    const nameInput = document.getElementById('editGuestName');
    const whatsappInput = document.getElementById('editWhatsappInput');
    const form = document.getElementById('editForm');

    if (modal && nameInput && whatsappInput && form) {
        nameInput.value = guestName;

        // Handle null, undefined, or empty whatsapp
        let whatsappValue = '';
        if (guestWhatsapp && typeof guestWhatsapp === 'string' && guestWhatsapp.trim() !== '') {
            whatsappValue = guestWhatsapp.trim().replace(/^62/, '');
        }
        whatsappInput.value = whatsappValue;
        whatsappInput.classList.remove('is-invalid');

        form.action = '/admin/guests/' + guestId;
        modal.classList.add('active');
    }
}

/**
 * Close edit guest modal
 */
function closeEditModal() {
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.remove('active');
    }
}

/**
 * Initialize search functionality
 */
function initializeSearch() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', filterGuests);
    }
}

/**
 * Filter guests by name
 */
function filterGuests() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('guestsTableBody');

    if (!searchInput || !tableBody) {
        return;
    }

    const searchText = searchInput.value.toLowerCase();
    const rows = tableBody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByClassName('guest-name')[0];
        if (nameCell) {
            const nameText = nameCell.textContent.toLowerCase();
            rows[i].style.display = nameText.includes(searchText) ? '' : 'none';
        }
    }
}

/**
 * Initialize alert auto-close
 */
function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                alert.style.display = 'none';
            });
        }
    });

    // Auto-close alerts after 5 seconds
    setTimeout(function() {
        alerts.forEach(function(alert) {
            if (alert.style.display !== 'none') {
                alert.style.display = 'none';
            }
        });
    }, 5000);
}

/**
 * Initialize delete buttons with confirmation
 */
function initializeDeleteButtons() {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const guestName = form.dataset.guestName;
            openDeleteConfirmation(guestName, form);
        });
    });

    // Close confirmation modal when clicking outside
    const confirmationModal = document.getElementById('confirmationModal');
    if (confirmationModal) {
        confirmationModal.addEventListener('click', function(e) {
            if (e.target === confirmationModal) {
                closeDeleteConfirmation();
            }
        });
    }
}

/**
 * Open delete confirmation modal
 */
function openDeleteConfirmation(guestName, form) {
    pendingDeleteForm = form;
    const modal = document.getElementById('confirmationModal');
    const title = document.getElementById('confirmationTitle');

    if (modal && title) {
        title.textContent = 'Hapus "' + guestName + '"?';
        modal.classList.add('active');
    }
}

/**
 * Close delete confirmation modal
 */
function closeDeleteConfirmation() {
    const modal = document.getElementById('confirmationModal');
    if (modal) {
        modal.classList.remove('active');
    }
    pendingDeleteForm = null;
}

/**
 * Confirm delete action
 */
function confirmDelete() {
    if (pendingDeleteForm) {
        pendingDeleteForm.submit();
    }
}

/**
 * Handle add form submission with WhatsApp validation and formatting
 */
function handleAddFormSubmit(event) {
    event.preventDefault();

    const form = document.getElementById('addForm');
    const nameInput = form.querySelector('input[name="name"]');
    const whatsappInput = document.getElementById('addWhatsappInput');

    // Validate name field
    const nameValue = (nameInput.value || '').trim();
    if (!nameValue) {
        alert('Nama Tamu wajib diisi!');
        nameInput.focus();
        return false;
    }

    if (form && whatsappInput) {
        const value = (whatsappInput.value || '').trim();

        // Check if WhatsApp is empty (required field)
        if (!value) {
            alert('Nomor WhatsApp wajib diisi!');
            whatsappInput.focus();
            return false;
        }

        // Validate WhatsApp input
        if (!validateWhatsAppInput(whatsappInput)) {
            alert('Nomor WhatsApp tidak valid! Gunakan format 8-12 digit dimulai dari 8 (contoh: 82216210360)');
            whatsappInput.focus();
            return false;
        }

        // Format WhatsApp for submission
        formatWhatsAppForSubmit(whatsappInput);

        // Submit form
        form.submit();
    }

    return false;
}

/**
 * Handle edit form submission with WhatsApp validation and formatting
 */
function handleEditFormSubmit(event) {
    event.preventDefault();

    const form = document.getElementById('editForm');
    const nameInput = document.getElementById('editGuestName');
    const whatsappInput = document.getElementById('editWhatsappInput');

    // Validate name field
    const nameValue = (nameInput.value || '').trim();
    if (!nameValue) {
        alert('Nama Tamu wajib diisi!');
        nameInput.focus();
        return false;
    }

    if (form && whatsappInput) {
        const value = (whatsappInput.value || '').trim();

        // Check if WhatsApp is empty (required field)
        if (!value) {
            alert('Nomor WhatsApp wajib diisi!');
            whatsappInput.focus();
            return false;
        }

        // Validate WhatsApp input
        if (!validateWhatsAppInput(whatsappInput)) {
            alert('Nomor WhatsApp tidak valid! Gunakan format 8-12 digit dimulai dari 8 (contoh: 82216210360)');
            whatsappInput.focus();
            return false;
        }

        // Format WhatsApp for submission
        formatWhatsAppForSubmit(whatsappInput);

        // Submit form
        form.submit();
    }

    return false;
}

/**
 * Initialize WhatsApp input formatting
 */
function initializeWhatsAppInputs() {
    const whatsappInputs = document.querySelectorAll('.whatsapp-input');
    whatsappInputs.forEach(function(input) {
        // Format on input event
        input.addEventListener('input', function() {
            formatWhatsAppInput(this);
        });

        // Validate on blur
        input.addEventListener('blur', function() {
            validateWhatsAppInput(this);
        });

        // Format on form submission
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                formatWhatsAppForSubmit(input);
            });
        }
    });
}

/**
 * Format WhatsApp input in real-time
 */
function formatWhatsAppInput(input) {
    let value = input.value;

    // Remove all non-digits
    value = value.replace(/\D/g, '');

    // If starts with 62, remove it (will be added automatically)
    if (value.startsWith('62')) {
        value = value.substring(2);
    }

    // Only allow starting with 8 (Indonesian numbers)
    if (value && !value.startsWith('8')) {
        value = '';
    }

    // Limit length to 12 digits (after 8)
    if (value.length > 12) {
        value = value.substring(0, 12);
    }

    input.value = value;
}

/**
 * Validate WhatsApp input
 */
function validateWhatsAppInput(input) {
    const value = (input.value || '').trim();

    // Empty value is allowed (optional field)
    if (!value) {
        input.classList.remove('is-invalid');
        return true;
    }

    // Check if it matches pattern: 8 followed by 9-12 digits
    const isValid = /^8\d{9,12}$/.test(value);

    if (!isValid) {
        input.classList.add('is-invalid');
        return false;
    }

    input.classList.remove('is-invalid');
    return true;
}

/**
 * Format WhatsApp number for form submission (add 62 prefix)
 */
function formatWhatsAppForSubmit(input) {
    let value = (input.value || '').trim();

    if (!value) {
        input.value = '';
        return true;
    }

    // Remove any 62 prefix if present
    if (value.startsWith('62')) {
        value = value.substring(2);
    }

    // Only allow format: 8 followed by 9-12 digits
    if (!/^8\d{9,12}$/.test(value)) {
        input.value = '';
        return false;
    }

    // Add 62 prefix for storage
    input.value = '62' + value;
    return true;
}

/**
 * Send WhatsApp invitation with pre-composed message
 */
function sendWhatsAppInvitation(phoneNumber, guestName, guestSlug, guestId, baseDomain = 'https://wedding-salma-fadli.malahphotobooth.com') {
    const invitationUrl = `${baseDomain}/${guestSlug}`;

    const message = `Kepada Yth.
Bapak/Ibu/Saudara/i
${guestName}
_______

Assalamu'alaikum wr. wb.

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, untuk menghadiri acara pernikahan kami.

Berikut link undangan untuk info lengkap dari acara, bisa kunjungi :

${invitationUrl}

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

Terima Kasih
Wassalamu'alaikum wr. wb.

Hormat kami,
Salma & Fadli
________`;

    // Encode message for URL
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

    // Update guest status to "Sudah Kirim Undangan"
    if (guestId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('Guest ID:', guestId, 'CSRF Token:', csrfToken?.content ? 'Found' : 'Not found');

        if (csrfToken) {
            const updateUrl = '/admin/guests/' + guestId;
            console.log('Fetching:', updateUrl);

            fetch(updateUrl, {
                method: 'PUT',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: 1
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Status updated successfully:', data);
                // Update status in the DOM
                const statusElement = document.querySelector(`.guest-status[data-guest-id="${guestId}"]`);
                if (statusElement) {
                    statusElement.textContent = 'Dikirim';
                    statusElement.classList.remove('guest-status-pending');
                    statusElement.classList.add('guest-status-sent');
                    statusElement.style.background = '#10b981';
                }
            })
            .catch(error => console.error('Error updating status:', error));
        } else {
            console.warn('CSRF token not found in page');
        }
    } else {
        console.warn('Guest ID not provided');
    }

    // Open WhatsApp with pre-composed message
    window.open(whatsappUrl, '_blank');
}
