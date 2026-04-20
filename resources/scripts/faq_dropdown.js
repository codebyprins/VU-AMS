const initFaqAccordion = () => {
    const faqItems = document.querySelectorAll('.faq_item');

    faqItems.forEach((item) => {
        const header = item.querySelector('.faq_header');
        const content = item.querySelector('.faq_content');

        if (!header || !content) {
            return;
        }

            header.style.cursor = 'pointer';
        header.setAttribute('role', 'button');
        header.setAttribute('tabindex', '0');
        header.setAttribute('aria-expanded', 'false');

        content.style.overflow = 'hidden';
        content.style.maxHeight = '0';
        content.style.opacity = '0';
        content.style.transition = 'max-height 0.35s ease, opacity 0.25s ease';
        content.style.display = 'block';

        const plusIcon = item.querySelector('.faq_icon--plus');
        const minusIcon = item.querySelector('.faq_icon--minus');

        const setIconState = (isOpen) => {
            if (plusIcon && minusIcon) {
                plusIcon.classList.toggle('hidden', isOpen);
                minusIcon.classList.toggle('hidden', !isOpen);
            }
        };

        const closeFaq = () => {
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            header.setAttribute('aria-expanded', 'false');
            item.classList.remove('faq_open');
            setIconState(false);
        };

        const openFaq = () => {
            const fullHeight = content.scrollHeight;
            content.style.maxHeight = `${fullHeight}px`;
            content.style.opacity = '1';
            header.setAttribute('aria-expanded', 'true');
            item.classList.add('faq_open');
            setIconState(true);
        };

        const toggleFaq = () => {
            if (item.classList.contains('faq_open')) {
                closeFaq();
            } else {
                openFaq();
            }
        };

        closeFaq();

        header.addEventListener('click', toggleFaq);
        header.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                toggleFaq();
            }
        });
    });
};

document.addEventListener('DOMContentLoaded', initFaqAccordion);