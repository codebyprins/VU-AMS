jQuery(function ($) {

  $('#sync-publications').on('click', function (e) {
    e.preventDefault();

    $('#sync-status').text('Syncing...');

    $.post(ajaxurl, {
      action: 'sync_publications'
    }, function (res) {
      $('#sync-status').text(res.data.message);
    });
  });

});