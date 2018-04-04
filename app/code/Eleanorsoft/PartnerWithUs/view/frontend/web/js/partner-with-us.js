define([
    'jquery',
    'uiComponent',
    'mage/validation'
], function ($, Component) {
    'use strict';

    return Component.extend({
        initialize: function (config) {
            var self = this;

            this.captchaEnabled = false;

            this._super();
            this.prepareFunctions(config);

            if (config.captchaSiteKey) {
                this.enableCaptcha(config);
            }
        },

        enableCaptcha: function (config) {
            var self = this,
                jForm = $(config.formSelector);

            grecaptcha.render(config.captchaRenderSelectorId, {
                'sitekey': config.captchaSiteKey,
                'callback': function(token) {
                    self.captchaEnabled = true;

                    self.submitPartnerWithUsForm(jForm);
                }
            });
        },

        beforeSend: function () {
            return true;
        },

        onSendError: function () {
            return true;
        },

        onSendSuccess: function () {
            return true;
        },

        prepareFunctions: function (config) {
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

        validatePartnerWithUsForm: function (jForm) {
            return jForm.validation() && jForm.validation('isValid');
        },

        submitPartnerWithUsForm: function(form) {
            var self = this,
                jForm = $(form),
                jSubmit = jForm.find(':submit');

            if (self.beforeSend() !== false && this.validatePartnerWithUsForm(jForm)) {
                jSubmit.prop('disabled', true);

                $.post(jForm.attr('action'), this.getFormValues(jForm), function (result) {
                    if (self.onSendSuccess() !== false) {
                        self.showSuccessMessage(result);
                    }
                }).fail(function (error) {
                    if (self.onSendError() !== false) {
                        self.showErrorMessage(error.responseText);
                    }
                }).always(function () {
                    jForm[0].reset();
                    jSubmit.prop('disabled', false);
                });
            }

            if (self.captchaEnabled) {
                grecaptcha.reset();
            }
        },

        getFormValues: function (jForm) {
            var values = {};

            $.each(jForm.serializeArray(), function(i, field) {
                values[field.name] = field.value;
            });

            return values;
        },

        showErrorMessage: function (message) {
            this.showMessage(message, 'error');
        },

        showSuccessMessage: function (message) {
            this.showMessage(message, 'success');
        },

        showMessage: function (message, type) {
            var jMessage = $('.message'),
                cssClass = 'message message-' + type + ' ' + type;

            jMessage.find('div').text(message);
            jMessage.removeClass();
            jMessage.addClass(cssClass);
            $('.page.messages').show();
        }
    });
});