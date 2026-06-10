const teamCards = Array.from(document.querySelectorAll('.team-card'));
const accordionButtons = Array.from(document.querySelectorAll('.accordion-toggle'));

if (teamCards.length) {
    const setCardHeights = () => {
        // Measure with all accordions closed
        accordionButtons.forEach(btn => {
            btn.nextElementSibling.style.maxHeight = '0px';
        });

        teamCards.forEach(card => {
            card.style.minHeight = '';
        });

        const tallestCard = Math.max(...teamCards.map(card => card.offsetHeight), 0);

        teamCards.forEach(card => {
            card.style.minHeight = `${tallestCard}px`;
        });
    };

    const closeAccordion = (btn) => {
        const b = btn.nextElementSibling;
        b.style.maxHeight = '0px';
        btn.textContent = 'Read more';
    };

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const body = button.nextElementSibling;
            const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';

            // Close all other open accordions first
            accordionButtons.forEach(otherBtn => {
                if (otherBtn !== button) {
                    const otherBody = otherBtn.nextElementSibling;
                    if (otherBody.style.maxHeight && otherBody.style.maxHeight !== '0px') {
                        closeAccordion(otherBtn);
                    }
                }
            });

            if (isOpen) {
                body.style.maxHeight = '0px';
                button.textContent = 'Read more';
            } else {
                body.style.maxHeight = body.scrollHeight + 'px';
                button.textContent = 'Read less';
            }
        });
    });

    window.addEventListener('load', () => {
        setCardHeights();
    });

    window.addEventListener('resize', () => {
        setCardHeights();
    });

    setCardHeights();
}