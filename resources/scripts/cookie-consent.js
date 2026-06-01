const CONSENT_KEY = 'vu_ams_cookie_consent';

document.addEventListener('DOMContentLoaded', () => {
    const overlay     = document.getElementById('cookie-consent-overlay');
    const settingsBtn = document.getElementById('cookie-settings-btn');
    if (!overlay) return;

    function showSettingsBtn() {
        if (!settingsBtn) return;
        settingsBtn.style.opacity = '0';
        settingsBtn.style.display = 'flex';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                settingsBtn.style.transition = 'opacity 0.4s ease';
                settingsBtn.style.opacity = '1';
            });
        });
    }

    function hideSettingsBtn() {
        if (!settingsBtn) return;
        settingsBtn.style.display = 'none';
    }

    function showOverlay() {
        overlay.style.removeProperty('display');
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            });
        });
    }

    // Show overlay on first visit, otherwise show the settings button
    if (!localStorage.getItem(CONSENT_KEY)) {
        setTimeout(showOverlay, 1000);
    } else {
        showSettingsBtn();
    }

    function dismissConsent(choice) {
        localStorage.setItem(CONSENT_KEY, choice);

        overlay.classList.add('opacity-0');
        overlay.classList.remove('opacity-100');

        setTimeout(() => {
            overlay.style.display = 'none';
            showSettingsBtn();
        }, 200);
    }

    settingsBtn?.addEventListener('click', () => {
        hideSettingsBtn();
        showOverlay();
    });

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
