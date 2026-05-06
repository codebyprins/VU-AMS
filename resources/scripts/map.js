document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.map_item').forEach(function(mapItem) {
    const locationId = mapItem.getAttribute('data-location-id');
    const mapInfo = mapItem.querySelector(`#map_info_${locationId}`);

    mapItem.addEventListener('click', function(e) {
      e.stopPropagation();
      
      document.querySelectorAll('.map_information').forEach(function(info) {
        if (info !== mapInfo) {
          info.classList.add('opacity-0', 'pointer-events-none');
          info.classList.remove('opacity-100', 'pointer-events-auto');
        }
      });
      
      mapInfo.classList.toggle('opacity-0');
      mapInfo.classList.toggle('pointer-events-none');
      mapInfo.classList.toggle('opacity-100');
      mapInfo.classList.toggle('pointer-events-auto');
    });

    document.addEventListener('click', function(e) {
      if (!mapItem.contains(e.target) && !mapInfo.contains(e.target)) {
        mapInfo.classList.add('opacity-0', 'pointer-events-none');
        mapInfo.classList.remove('opacity-100', 'pointer-events-auto');
      }
    });
  });
});
