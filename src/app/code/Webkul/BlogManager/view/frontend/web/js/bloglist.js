define([
    "jquery",
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, confirmation, alert, $t) {
    'use strict';

    return function(config) {
        // Use event delegation for dynamically loaded content
        $(document).on('click', '.blog-list-table-action-delete a', function(e) {
            var self = this;
            e.preventDefault();

            confirmation({
                title: $t('Delete?'),
                content: $t('Are you sure you want to delete this blog?'),
                actions: {
                    confirm: function() {
                        var url = $(self).attr('href');
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: url,
                            data: {},
                            beforeSend: function() {
                                $('body').trigger("processStart");
                            },
                            success: function(response) {
                                $('body').trigger("processStop");
                                if (response.success) {
                                    $(self).closest('.blog-list-table-row').fadeOut(400, function() {
                                        $(this).remove();
                                    });
                                    alert({
                                        title: $t('Success'),
                                        content: response.message || $t('Blog was successfully deleted.')
                                    });
                                } else {
                                    alert({
                                        title: $t('Error'),
                                        content: response.message || $t('Error deleting blog.')
                                    });
                                }
                            },
                            error: function(response) {
                                $('body').trigger("processStop");
                                alert({
                                    title: $t('Error'),
                                    content: $t('Something went wrong.')
                                });
                            }
                        });
                    }
                }
            });
        });
    };
});
