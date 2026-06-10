(function() {
    if (typeof document === 'undefined') {
        return;
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.productusbs-section details').forEach(function(details) {
            var summary = details.querySelector('summary');
            var icon = details.querySelector('.productusbs-toggle-icon');
            if (!summary || !icon) {
                return;
            }

            var updateIcon = function() {
                icon.textContent = details.open ? '−' : '+';
            };

            updateIcon();
            summary.addEventListener('click', function() {
                setTimeout(updateIcon, 0);
            });
        });
    });
})();