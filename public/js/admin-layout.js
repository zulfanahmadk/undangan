function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const container = document.querySelector('.admin-container');
    
    sidebar.classList.toggle('collapsed');
    container.classList.toggle('sidebar-collapsed');
    
    // Save preference
    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
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
});
