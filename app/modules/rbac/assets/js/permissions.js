yii.permission = (function($, w) {
    var pub = {
        url: null,
        init: function() {
            var self = this,
                $container = $('#permissions');
            self.url = $container.data('url');
            
            $container.on('change', '.assign', function() {
                var $el = $(this);
                self.assign($el.data('role'), $el.data('permission'), $el.is(':checked'), $el);
            });
        },
        assign: function(role, permission, val, $el) {
            $.post(this.url, {role: role, permission: permission, assign: val ? 1 : 0  }, 'json').fail(function(xhr, status) {
                alert(xhr.responseText);
                $el.attr('checked', !val);
            }).done(function(data, status, xhr) {
                data = JSON.parse(data);
                if (data.success) {
                    noty({
                        timeout: 3500,
						text: I18NS.success,
						type: 'success',
						theme: 'tisa_theme',
						layout: 'topRight',
						closeWith: ['button'],
						killer: true
					});
                } else {
                    noty({
                        timeout: 3500,
						text: I18NS.error,
						type: 'error',
						theme: 'tisa_theme',
						layout: 'topRight',
						closeWith: ['button'],
						killer: true
					});
                }
            });
        }
    };
    return pub
    
})(jQuery, window);

