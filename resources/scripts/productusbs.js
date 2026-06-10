(function() {
    if (typeof document === 'undefined') {
        return;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.productusbs-section details').forEach(function(details) {
            var icon = details.querySelector('.productusbs-toggle-icon');
            if (!icon) {
                return;
            }

            var updateIcon = function() {
                icon.textContent = details.open ? '−' : '+';
            };

            updateIcon();
            details.addEventListener('toggle', updateIcon);
        });
    });
})();