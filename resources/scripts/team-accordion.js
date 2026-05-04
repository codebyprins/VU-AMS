document.querySelectorAll('.accordion-toggle').forEach(button => {
    button.addEventListener('click', () => {
        const body = button.nextElementSibling;
        const isOpen = body.style.maxHeight && body.style.maxHeight !== '0px';

        if (isOpen) {
            body.style.maxHeight = '0px';
            button.textContent = 'Read more';
        } else {
            body.style.maxHeight = body.scrollHeight + 'px';
            button.textContent = 'Read less';
        }
    });
});