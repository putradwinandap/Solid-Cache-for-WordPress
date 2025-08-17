
(function ($) {
    'use strict';

    window.flushCache = function ($btn) {
        $.ajax({
            url: ptrSoc.url,              // dari wp_localize_script
            type: 'POST',
            //dataType: 'json',
            data: {
                action: 'ptrsoc_flush_cache',
                _ajax_nonce: ptrSoc.nonce   // validasi nonce di server
            },
            beforeSend: function () {
                $btn.text(ptrSoc.loading);
            },
            success: function (res) {
                if (res && res.success) {
                    // contoh notifikasi sederhana
                    alert(res.data?.message || 'Berhasil flush.');
                } else {
                    alert(res?.data?.message || 'Gagal flush.');
                }
            },
            error: function (xhr, status, err) {
                console.error('AJAX error:', status, err);
                alert('Terjadi kesalahan koneksi.');
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