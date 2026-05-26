(function (window, $) {
  if (!$) {
    return;
  }

  $(function () {
    var $button = $('#sync-publications');
    var $status = $('#sync-status');
    var ajaxUrl = window.vuAmsPublicationSync && window.vuAmsPublicationSync.ajaxUrl;

    if (!$button.length || !$status.length || !ajaxUrl) {
      return;
    }

    $button.on('click', function (e) {
      e.preventDefault();

      $button.prop('disabled', true);
      $status.text('Syncing...');

      $.post(ajaxUrl, {
        action: 'sync_publications'
      }).done(function (res) {
        var message = res && res.data && res.data.message
          ? res.data.message
          : 'Sync finished.';

        $status.text(message);
      }).fail(function () {
        $status.text('Sync failed. Please try again.');
      }).always(function () {
        $button.prop('disabled', false);
      });
    });
  });
})(window, window.jQuery);
