document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("newsletter-popup");
    const closeBtn = document.getElementById("close-popup");
    const signUpBtn = document.querySelector("footer .btn-secondary");

    if (!popup || !closeBtn) return;

    if (signUpBtn) {
        signUpBtn.addEventListener("click", () => {
            popup.classList.remove("hidden");
            popup.classList.add("flex");
        });
    }

    closeBtn.addEventListener("click", () => {
        popup.classList.add("hidden");
        popup.classList.remove("flex");
    });

    popup.addEventListener("click", (e) => {
        if (e.target === popup) {
            popup.classList.add("hidden");
            popup.classList.remove("flex");
        }
    });
});