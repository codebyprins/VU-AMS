document.querySelectorAll('.productus-toggle').forEach(button => {
    button.addEventListener('click', () => {
        const wrapper = button.parentElement;
        const content = wrapper.querySelector('.productus-content');
        const icon = button.querySelector('.productus-toggle-icon');

        const isOpen = button.getAttribute('aria-expanded') === 'true';

        // close all others
        document.querySelectorAll('.productus-toggle').forEach(otherButton => {
            if (otherButton !== button) {
                const otherWrapper = otherButton.parentElement;
                const otherContent = otherWrapper.querySelector('.productus-content');
                const otherIcon = otherButton.querySelector('.productus-toggle-icon');

                otherContent.style.maxHeight = null;
                otherContent.classList.add('max-h-0', 'hidden');

                otherButton.setAttribute('aria-expanded', 'false');
                otherIcon.textContent = '+';
            }
        });

        // toggle current
        if (isOpen) {
            content.style.maxHeight = null;
            content.classList.add('max-h-0', 'hidden');

            button.setAttribute('aria-expanded', 'false');
            icon.textContent = '+';
        } else {
            content.classList.remove('max-h-0', 'hidden');
            content.style.maxHeight = content.scrollHeight + 'px';

            button.setAttribute('aria-expanded', 'true');
            icon.textContent = '−';
        }
    });
});