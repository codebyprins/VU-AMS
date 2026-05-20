var items = document.getElementsByClassName("accordion-item");

for (let i = 0; i < items.length; i++) {
  let header = items[i].querySelector(".accordion-header");

  header.addEventListener("click", function () {

    let item = this.parentElement;
    let panel = item.querySelector(".panel");
    let icon = item.querySelector(".icon");

    item.classList.toggle("active");

    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
      icon.innerHTML = "+";
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
      icon.innerHTML = "−";
    }
  });
}