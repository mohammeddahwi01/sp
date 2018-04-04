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

                    self.submitForm(jForm);
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
            var self = this;

            if (config.beforeSend) {
                eval('self.beforeSend = ' + config.beforeSend);
            }

            if (config.onSendError) {
                eval('self.onSendError = ' + config.onSendError);
            }

            if (config.onSendSuccess) {
                eval('self.onSendSuccess = ' + config.onSendSuccess);
            }
        },

        validateForm: function (jForm) {
            return jForm.validation() && jForm.validation('isValid');
        },

        submitForm: function(form)
        {
            var self = this,
                jForm = $(form),
                jSubmit = jForm.find(':submit');

            if (self.beforeSend() !== false && this.validateForm(jForm)) {
                jSubmit.prop('disabled', true);
                jQuery.ajax({
                    url: jForm.attr('action'),
                    data: this.getFormValues(jForm),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success: function(result){
                        if (self.onSendSuccess() !== false) {
                            jForm[0].reset();
                            self.showSuccessMessage(result);
                        }
                    }
                }).fail(function (error) {
                    if (self.onSendError() !== false) {
                        self.showErrorMessage(error.responseText);
                    }
                }).always(function () {
                    jSubmit.prop('disabled', false);
                });

            }

            if (self.captchaEnabled) {
                grecaptcha.reset();
            }
        },

        getFormValues: function(jForm)
        {
            var data = new FormData(jForm[0]);
            return data;
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