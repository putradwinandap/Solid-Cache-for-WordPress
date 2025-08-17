
(function ($) {
    'use strict';

    /**
     * Flush the cache via AJAX.
     * @param $btn The button element that triggered the flush.
     */
    window.flushCache = function ($btn) {
        $.ajax({
            url: ptrSoc.url,
            type: 'POST',
            data: {
                action: 'ptrsoc_flush_cache',
                _ajax_nonce: ptrSoc.nonce
            },
            beforeSend: function () {
                $btn.text(ptrSoc.loading);
            },
            success: function (res) {
                alert(res.data.message);
            },
            error: function (xhr, status, err) {
                console.error('AJAX error:', status, err);
                alert(ptrSoc.errorMessage);
            },
            complete: function () {
                $btn.prop('disabled', false).removeAttr('aria-busy').text(ptrSoc.flushCacheTitle);
            }
        });
    }

    $(document).on("click", "#wp-admin-bar-ptrsoc-flush-cache > a", function (e) {
        e.preventDefault();

        if (!window.confirm(ptrSoc.confirmFlush)) {
            return;
        }
        const $btn = $(this);
        $btn.prop('disabled', true).attr('aria-busy', 'true');
        flushCache($btn);
    });
})(jQuery);