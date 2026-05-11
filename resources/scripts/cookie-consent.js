const CONSENT_KEY = 'vu_ams_cookie_consent';

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('cookie-consent-overlay');
    if (!overlay) return;

    // Only show if the user hasn't made a choice yet
    if (!localStorage.getItem(CONSENT_KEY)) {
        // Remove the inline display:none and let it appear
        overlay.style.removeProperty('display');
        // Trigger fade-in on next frame
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
        });
    }

    function dismissConsent(choice) {
        localStorage.setItem(CONSENT_KEY, choice);

        overlay.classList.add('opacity-0');
        overlay.classList.remove('opacity-100');

        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300);
    }

    document.getElementById('cookie-accept-all')?.addEventListener('click', () => {
        dismissConsent('all');
    });

    document.getElementById('cookie-accept-necessary')?.addEventListener('click', () => {
        dismissConsent('necessary');
    });

    document.getElementById('cookie-reject-all')?.addEventListener('click', () => {
        dismissConsent('none');
    });
});
