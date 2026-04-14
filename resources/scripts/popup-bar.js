document.addEventListener("DOMContentLoaded", () => {
  const popup = document.getElementById("popup");
  if (!popup) {
    return;
  }

  requestAnimationFrame(() => {
    popup.classList.remove("opacity-0", "translate-y-4");
    popup.classList.add("opacity-100", "translate-y-0");
  });
});

function closePopup() {
  const popup = document.getElementById("popup");
  if (!popup) {
    return;
  }

  popup.classList.add("opacity-0", "translate-y-4");
  popup.classList.remove("opacity-100", "translate-y-0");

  setTimeout(() => {
    popup.style.display = "none";
  }, 500);
}

window.closePopup = closePopup;
