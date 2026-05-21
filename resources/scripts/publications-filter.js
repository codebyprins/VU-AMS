document.addEventListener('DOMContentLoaded', function () {

    const el = document.querySelector('select[name="keyword[]"]');

    if (!el) return;

    new Choices(el, {
        removeItemButton: true,
        shouldSort: false,
        placeholder: true,
        placeholderValue: 'Select keywords'
    });

});