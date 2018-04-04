define([
    'jquery',
    'uiComponent',
    'mage/validation'
], function ($, Component) {
    'use strict';

    return Component.extend({
        initialize: function (config) {
            this._super();
            this.prepareFunctions(config);
        },

        afterSend: function (jForm) {
            return true;
        },

        beforeSend: function (jForm) {
            return true;
        },

        onSendError: function () {
            return true;
        },

        onSendSuccess: function () {
            return true;
        },

        prepareFunctions: function (config) {
            if (config.afterSend) {
                eval('this.afterSend = ' + config.afterSend);
            }

            if (config.beforeSend) {
                eval('this.beforeSend = ' + config.beforeSend);
            }

            if (config.onSendError) {
                eval('this.onSendError = ' + config.onSendError);
            }

            if (config.onSendSuccess) {
                eval('this.onSendSuccess = ' + config.onSendSuccess);
            }
        },

        validateForm: function (jForm) {
            return jForm.validation() && jForm.validation('isValid');
        },

        getFormValues: function (jForm) {
            var values = {};

            $.each(jForm.serializeArray(), function(i, field) {
                if (field.name in values) {
                    if (!Array.isArray(values[field.name])) {
                        var firstValue = values[field.name];

                        values[field.name] = [];

                        values[field.name].push(firstValue);
                        values[field.name].push(field.value);
                    } else {
                        values[field.name].push(field.value);
                    }
                } else {
                    values[field.name] = field.value;
                }
            });

            return values;
        },

        submitForm: function (form) {
            var self = this,
                jForm = $(form),
                jSubmit = jForm.find(':submit');

            if (self.beforeSend(jForm) !== false && this.validateForm(jForm)) {
                jSubmit.prop('disabled', true);

                $.post(jForm.attr('action'), this.getFormValues(jForm), function (rawResponse) {
                    var response = (typeof rawResponse !== 'object') ? JSON.parse(rawResponse) : rawResponse,
                        isSuccess = response.success,
                        firstMessage = response.messages[0];

                    if (isSuccess) {
                        if (self.onSendSuccess() !== false) {
                            self.showSuccessMessage(jForm, firstMessage);
                        }
                    } else {
                        if (self.onSendError() !== false) {
                            self.showErrorMessage(jForm, firstMessage);
                        }
                    }
                }).fail(function (error) {
                    if (self.onSendError() !== false) {
                        self.showErrorMessage(jForm, error.responseText);
                    }
                }).always(function () {
                    jSubmit.prop('disabled', false);

                    if (self.afterSend(jForm)) {
                        jForm.find('[type=password]').val('');
                    }
                });
            }
        },

        showErrorMessage: function (jForm, message) {
            this.showMessage(jForm, message, 'error');
        },

        showSuccessMessage: function (jForm, message) {
            this.showMessage(jForm, message, 'success');
        },

        showMessage: function (jForm, message, type) {
            var jMessage = jForm.find('.message'),
                cssClass = 'message message-' + type + ' ' + type;

            jMessage.find('div').html(message);
            jMessage.removeClass();
            jMessage.addClass(cssClass);
            $('.page.messages').show();
        }
    });
});