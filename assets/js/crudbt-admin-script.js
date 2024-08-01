;(function($) {

    $('table.wp-list-table.items').on('click', 'a.itemdelete', function(e) {
        e.preventDefault();

        if (!confirm(crudbt.confirm)) {
            return;
        }

        var self = $(this);

        wp.ajax.post('crudbt-delete-item', {
            id: $(this).data('id'),
            _wpnonce: crudbt.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(crudbt.error);
        });
    });

})(jQuery);
