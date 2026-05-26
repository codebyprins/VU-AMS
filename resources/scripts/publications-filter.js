document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form[method="GET"]');

  if (!form) return;

  form.addEventListener('submit', function () {

    const fields = form.querySelectorAll('input, select');

    fields.forEach(field => {

      // multi select
      if (field.multiple) {

        const selected = Array.from(field.selectedOptions);

        if (!selected.length) {
          field.disabled = true;
        }

        return;
      }

      // normal empty fields
      if (!field.value) {
        field.disabled = true;
      }

    });

  });

  const el = document.querySelector('select[name="keyword[]"]');

  if (!el) return;

  new Choices(el, {
    removeItemButton: true,
    shouldSort: false,
    placeholder: true,
    placeholderValue: 'Select keywords'
  });

});