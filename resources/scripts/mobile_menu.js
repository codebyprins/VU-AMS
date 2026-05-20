document.addEventListener('DOMContentLoaded', () => {
    const wrap  = document.getElementById('topbar-marquee-wrap');
    const inner = document.getElementById('topbar-marquee-inner');
    if (wrap && inner) {
        const clone = inner.cloneNode(true);
        clone.removeAttribute('id');
        wrap.appendChild(clone);
        const itemWidth = inner.offsetWidth;
        let pos  = 0;
        let last = null;
        const speed = 40;
        function tick(ts) {
            if (!last) last = ts;
            const dt = Math.min((ts - last) / 1000, 0.05);
            last = ts;
            pos -= speed * dt;
            if (pos <= -itemWidth) pos += itemWidth;
            wrap.style.transform = `translateX(${pos}px)`;
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    const toggle        = document.getElementById('mobile-menu-toggle');
    const closeBtn      = document.getElementById('mobile-menu-close');
    const menu          = document.getElementById('mobile-menu');
    const overlay       = document.getElementById('mobile-overlay');
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose     = document.getElementById('icon-close');

    if (!toggle || !closeBtn || !menu || !overlay) {
        console.warn('[MobileMenu] Eén of meer menu-elementen niet gevonden:', {
            toggle, closeBtn, menu, overlay
        });
    }

    function openMenu() {
        if (!menu || !overlay) return;
        menu.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        iconHamburger?.classList.add('hidden');
        iconClose?.classList.remove('hidden');
        console.log('[MobileMenu] Menu geopend');
    }

    function closeMenu() {
        if (!menu || !overlay) return;
        menu.classList.add('translate-x-full');
        overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        iconHamburger?.classList.remove('hidden');
        iconClose?.classList.add('hidden');
        console.log('[MobileMenu] Menu gesloten');
    }

    if (toggle) toggle.addEventListener('click', openMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);

    document.querySelectorAll('[data-submenu-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const li      = btn.closest('li');
            const submenu = li.querySelector('[data-submenu]');
            if (!submenu) return;
            const isOpen = !submenu.classList.contains('hidden');
            const icon   = btn.querySelector('svg');
            if (isOpen) {
                submenu.classList.add('hidden');
                icon.classList.remove('rotate-180');
            } else {
                submenu.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
});