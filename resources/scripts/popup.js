document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("newsletter-popup");
    const closeBtn = document.getElementById("close-popup");

    if (!popup || !closeBtn) return;

    // Show after 2 seconds
    setTimeout(() => {
        popup.classList.remove("hidden");
        popup.classList.add("flex");
    }, 2000);

    // Close on button click
    closeBtn.addEventListener("click", () => {
        popup.classList.add("hidden");
    });

    // Optional: close when clicking outside modal
    popup.addEventListener("click", (e) => {
        if (e.target === popup) {
            popup.classList.add("hidden");
        }
    });
});