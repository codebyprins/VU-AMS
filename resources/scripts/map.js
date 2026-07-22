document.addEventListener("DOMContentLoaded", () => {
  const mapItems = document.querySelectorAll(".map_item");
  const mapInfos = document.querySelectorAll(".map_information");

  // Set default z-index
  mapItems.forEach(function (mapItem) {
    mapItem.classList.add("z-10");
  });

  mapItems.forEach(function (mapItem) {
    const locationId = mapItem.getAttribute("data-location-id");
    const mapInfo = document.getElementById(`map_info_${locationId}`);

    // Hover: show ring while hovering
    mapItem.addEventListener("mouseenter", function () {
      if (!mapItem.classList.contains("ring-2")) {
        mapItem.classList.add("ring-2", "ring-secondary");
      }
    });

    mapItem.addEventListener("mouseleave", function () {
      // Keep ring if this item's info is open
      if (!mapInfo.classList.contains("opacity-100")) {
        mapItem.classList.remove("ring-2", "ring-secondary");
      }
    });

    mapItem.addEventListener("click", function (e) {
      e.stopPropagation();

      const isOpen = mapInfo.classList.contains("opacity-100");

      // Close all infos
      mapInfos.forEach(function (info) {
        info.classList.add("opacity-0", "pointer-events-none");
        info.classList.remove("opacity-100", "pointer-events-auto");
      });

      // Reset all map items
      mapItems.forEach(function (item) {
        item.classList.remove("ring-2", "ring-secondary", "z-50");
        item.classList.add("z-10");
      });

      // If the clicked item was closed, open it
      if (!isOpen) {
        // Bring clicked item and its info above all other dots
        mapItem.classList.remove("z-10");
        mapItem.classList.add("z-50");

        // Add active ring
        mapItem.classList.add("ring-2", "ring-secondary");

        // Show info
        mapInfo.classList.remove("opacity-0", "pointer-events-none");
        mapInfo.classList.add("opacity-100", "pointer-events-auto");
      }
    });
  });

  // Close everything when clicking outside the map
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".map_item")) {
      // Close all infos
      mapInfos.forEach(function (info) {
        info.classList.add("opacity-0", "pointer-events-none");
        info.classList.remove("opacity-100", "pointer-events-auto");
      });

      // Reset all map items
      mapItems.forEach(function (item) {
        item.classList.remove("ring-2", "ring-secondary", "z-50");
        item.classList.add("z-10");
      });
    }
  });
});