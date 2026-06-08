  document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.50 });

    document.querySelectorAll('.fade-in-up-cards').forEach((el) => {
      observer.observe(el);
    });
  });