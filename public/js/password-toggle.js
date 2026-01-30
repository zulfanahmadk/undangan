/**
 * Password Toggle Functionality
 * Adds show/hide password feature to all password inputs
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize password toggles for all password inputs
    initializePasswordToggles();
});

function initializePasswordToggles() {
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    
    passwordInputs.forEach((input) => {
        // Skip if already wrapped
        if (input.parentElement.classList.contains('password-input-group')) {
            return;
        }

        // Create wrapper
        const wrapper = document.createElement('div');
        wrapper.className = 'password-input-group';

        // Create toggle button
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'password-toggle-btn';
        toggleBtn.setAttribute('title', 'Tampilkan password');
        toggleBtn.innerHTML = '👁️';
        toggleBtn.style.display = 'flex'; // Ensure button is visible

        // Insert wrapper before input
        input.parentNode.insertBefore(wrapper, input);
        
        // Move input into wrapper
        wrapper.appendChild(input);
        
        // Add toggle button to wrapper
        wrapper.appendChild(toggleBtn);

        // Add click handler
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            togglePasswordVisibility(input, toggleBtn);
        });
    });
}

function togglePasswordVisibility(input, toggleBtn) {
    const isPassword = input.type === 'password';
    
    if (isPassword) {
        // Show password
        input.type = 'text';
        toggleBtn.classList.add('show');
        toggleBtn.setAttribute('title', 'Sembunyikan password');
        toggleBtn.innerHTML = '🙈';
    } else {
        // Hide password
        input.type = 'password';
        toggleBtn.classList.remove('show');
        toggleBtn.setAttribute('title', 'Tampilkan password');
        toggleBtn.innerHTML = '👁️';
    }
}

// Reinitialize password toggles if new password inputs are added dynamically (e.g., in modals)
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
            // Check if any added nodes contain password inputs
            const addedPasswordInputs = Array.from(mutation.addedNodes)
                .flatMap(node => {
                    if (node.querySelectorAll) {
                        return Array.from(node.querySelectorAll('input[type="password"]'));
                    }
                    if (node.type === 'password') {
                        return [node];
                    }
                    return [];
                })
                .filter(input => !input.parentElement.classList.contains('password-input-group'));
            
            // Initialize toggles for newly added password inputs
            if (addedPasswordInputs.length > 0) {
                setTimeout(() => {
                    initializePasswordToggles();
                }, 100);
            }
        }
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});
