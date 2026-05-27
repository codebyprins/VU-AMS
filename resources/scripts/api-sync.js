(function (window, $) {
  if (!$) {
    return;
  }

  $(function () {
    var $button = $('#sync-publications');
    var $status = $('#sync-status');
    var $modal = $('#publication-sync-modal');
    var $message = $('#publication-sync-modal-message');
    var $bar = $('#publication-sync-progress-bar');
    var $progressText = $('#publication-sync-progress-text');
    var $countText = $('#publication-sync-count-text');
    var $log = $('#publication-sync-log');
    var $close = $('#publication-sync-close');
    var config = window.vuAmsPublicationSync || {};
    var ajaxUrl = config.ajaxUrl;
    var nonce = config.nonce;
    var pollTimer = null;

    if (!$button.length || !$status.length || !$modal.length || !ajaxUrl || !nonce) {
      return;
    }

    function post(action, data) {
      return $.post(ajaxUrl, $.extend({
        action: action,
        nonce: nonce
      }, data || {}));
    }

    function openModal() {
      $modal.css('display', 'flex');
      $close.text('Close').prop('disabled', true);
      $log.empty();
      updateModal({
        message: 'Starting publication sync...',
        processed: 0,
        total: 0,
        percent: 0,
        log: []
      });
    }

    function closeModal() {
      $modal.hide();
    }

    function stopPolling() {
      if (pollTimer) {
        window.clearInterval(pollTimer);
        pollTimer = null;
      }
    }

    function updateModal(syncStatus) {
      var processed = parseInt(syncStatus.processed || 0, 10);
      var total = parseInt(syncStatus.total || 0, 10);
      var percent = parseInt(syncStatus.percent || 0, 10);
      var log = syncStatus.log || [];

      $message.text(syncStatus.message || 'Syncing publications...');
      $bar.css('width', percent + '%');
      $progressText.text(percent + '%');
      $countText.text(processed + ' / ' + total);

      $log.empty();
      log.forEach(function (entry) {
        $('<p />')
          .text('[' + entry.time + '] ' + entry.text)
          .appendTo($log);
      });

      $log.scrollTop($log.prop('scrollHeight'));

      if (syncStatus.done) {
        stopPolling();
        $button.prop('disabled', false);
        $close.text('Close').prop('disabled', false);
      }
    }

    function pollStatus() {
      post('publication_sync_status').done(function (res) {
        if (res && res.success && res.data && res.data.status) {
          updateModal(res.data.status);
        }
      });
    }

    function startPolling() {
      stopPolling();
      pollStatus();
      pollTimer = window.setInterval(pollStatus, 1000);
    }

    $button.on('click', function (e) {
      e.preventDefault();

      $button.prop('disabled', true);
      $status.text('Syncing...');
      openModal();
      startPolling();

      post('sync_publications').done(function (res) {
        var message = res && res.data && res.data.message
          ? res.data.message
          : 'Sync finished.';

        $status.text(message);

        if (res && res.data && res.data.status) {
          updateModal(res.data.status);
        }
      }).fail(function (xhr) {
        var message = xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message
          ? xhr.responseJSON.data.message
          : 'Sync failed. Please try again.';

        $status.text(message);
        $message.text(message);
        stopPolling();
        $button.prop('disabled', false);
        $close.text('Close').prop('disabled', false);
      });
    });

    $close.on('click', function () {
      if ($close.prop('disabled')) {
        return;
      }

      closeModal();
    });
  });
})(window, window.jQuery);
