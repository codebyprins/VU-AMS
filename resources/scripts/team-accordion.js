const teamCards = Array.from(document.querySelectorAll('.team-card'));
const accordionButtons = Array.from(document.querySelectorAll('.accordion-toggle'));

if (teamCards.length) {
    const syncOpenAccordions = () => {
        document.querySelectorAll('.accordion-body').forEach(body => {
            if (body.style.maxHeight && body.style.maxHeight !== '0px') {
                body.style.maxHeight = body.scrollHeight + 'px';
            }
        });
    };

    const syncCardHeights = () => {
        syncOpenAccordions();
        teamCards.forEach(card => {
            card.style.minHeight = '';
        });

        const tallestCard = Math.max(...teamCards.map(card => card.offsetHeight), 0);

        teamCards.forEach(card => {
            card.style.minHeight = `${tallestCard}px`;
        });
    };

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const body = button.nextElementSibling;
            const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';

            if (isOpen) {
                body.style.maxHeight = '0px';
                button.textContent = 'Read more';
                body.addEventListener('transitionend', syncCardHeights, { once: true });
            } else {
                body.style.maxHeight = body.scrollHeight + 'px';
                button.textContent = 'Read less';
                requestAnimationFrame(syncCardHeights);
            }
        });
    });

    window.addEventListener('load', () => {
        syncCardHeights();
    });

    window.addEventListener('resize', () => {
        syncCardHeights();
    });

    syncCardHeights();
}