function updateMobileMenuToggle() {
    const sidebar = document.getElementById('adminSidebar');
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const isCollapsed = sidebar.classList.contains('collapsed');
    const isMobile = window.innerWidth <= 768;

    if (isMobile && isCollapsed) {
        mobileToggle.classList.add('visible');
    } else {
        mobileToggle.classList.remove('visible');
        mobileToggle.classList.remove('active');
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const container = document.querySelector('.admin-container');
    const mobileToggle = document.getElementById('mobileMenuToggle');

    sidebar.classList.toggle('collapsed');
    container.classList.toggle('sidebar-collapsed');

    if (mobileToggle) {
        mobileToggle.classList.toggle('active');
    }

    // Save preference
    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

    // Update mobile menu toggle visibility
    updateMobileMenuToggle();
}

// Session timeout configuration (5 minutes = 300000 ms)
let inactivityTimeout;
const INACTIVITY_DURATION = 5 * 60 * 1000; // 5 minutes

function resetInactivityTimer() {
    // Clear existing timeout
    if (inactivityTimeout) {
        clearTimeout(inactivityTimeout);
    }

    // Set new timeout
    inactivityTimeout = setTimeout(function() {
        // Auto logout due to inactivity
        const logoutForm = document.getElementById('logoutForm');
        if (logoutForm) {
            logoutForm.submit();
        }
    }, INACTIVITY_DURATION);
}

function setupInactivityDetection() {
    // List of events that indicate user activity
    const activityEvents = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'];

    activityEvents.forEach(function(eventName) {
        document.addEventListener(eventName, resetInactivityTimer, true);
    });

    // Initialize timer on page load
    resetInactivityTimer();
}

// Load saved sidebar state and initialize user menu
document.addEventListener('DOMContentLoaded', function() {
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        const sidebar = document.getElementById('adminSidebar');
        const container = document.querySelector('.admin-container');
        sidebar.classList.add('collapsed');
        container.classList.add('sidebar-collapsed');
    }

    // Update mobile menu toggle visibility
    updateMobileMenuToggle();

    // Mobile menu toggle button
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleSidebar);
    }

    // Sidebar toggle button
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', toggleSidebar);
    }

    // Close sidebar when backdrop is clicked on mobile
    const container = document.querySelector('.admin-container');
    if (container) {
        container.addEventListener('click', function(e) {
            if (e.target === container && window.innerWidth <= 768) {
                const sidebar = document.getElementById('adminSidebar');
                if (!sidebar.classList.contains('collapsed')) {
                    toggleSidebar();
                }
            }
        });
    }

    // User menu dropdown
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenuBtn.classList.toggle('active');
            userDropdown.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                userMenuBtn.classList.remove('active');
                userDropdown.classList.remove('active');
            }
        });
    }

    // Logout link handler
    const logoutLink = document.getElementById('logoutLink');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            const logoutForm = document.getElementById('logoutForm');
            if (logoutForm) {
                logoutForm.submit();
            }
        });
    }

    // Initialize session inactivity detection
    setupInactivityDetection();
});

// Handle window resize to update mobile menu toggle visibility
window.addEventListener('resize', updateMobileMenuToggle);
