document.addEventListener('DOMContentLoaded', function() {
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
