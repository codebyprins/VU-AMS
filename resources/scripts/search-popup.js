document.addEventListener('DOMContentLoaded', function() {
    const searchPopup = document.querySelector('.search-popup');
    const modal = document.getElementById('search-modal');
    const openBtn = document.getElementById('search-popup_open');
    const closeBtn = document.getElementById('search-popup_close');
    const overlay = searchPopup.querySelector('.absolute.inset-0');

    function openPopup() {
        searchPopup.classList.remove('hidden', 'pointer-events-none');

        modal.classList.remove('hidden', '-translate-y-[40%]');
        modal.classList.add('-translate-y-1/2', 'block');
    }

    function closePopup() {
        searchPopup.classList.add('hidden', 'pointer-events-none');

        modal.classList.add('hidden', '-translate-y-[40%]');
        modal.classList.remove('-translate-y-1/2', 'block');
    }

    openBtn.addEventListener('click', openPopup);
    closeBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', closePopup);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePopup();
        }
    });
});