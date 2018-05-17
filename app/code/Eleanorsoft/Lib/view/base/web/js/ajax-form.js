define([
    'jquery',
    'uiComponent',
    'mage/validation'
], function ($, Component) {
    'use strict';

    return Component.extend({
        initialize: function (config) {
            this.captchaEnabled = false;

            this._super();
            this.prepareFunctions(config);

            if (config.captchaSiteKey) {
                this.enableCaptcha(config);
            }
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

        validateForm: function (jForm) {
            return jForm.validation() && jForm.validation('isValid');
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

        submitForm: function (form) {
            var self = this,
                jForm = $(form);

            if (self.beforeSend(jForm) !== false && this.validateForm(jForm)) {
                jForm.find(':submit').prop('disabled', true);
                self.makeRequest(jForm);
            }

            if (self.captchaEnabled) {
                grecaptcha.reset();
            }
        },

        processFailResponse: function (jForm, error) {
            if (this.onSendError() !== false) {
                this.showErrorMessage(jForm, error.responseText);
            }
        },

        processAfterResponse: function (jForm) {
            jForm.find(':submit').prop('disabled', false);

            if (this.afterSend(jForm)) {
                jForm.find('[type=password]').val('');
            }
        },

        makeRequest: function (jForm) {
            var self = this;

            $.post(jForm.attr('action'), jForm.serialize(), function (rawResponse) {
                self.processResponse(jForm, rawResponse);
            }).fail(function (error) {
                self.processFailResponse(jForm, error);
            }).always(function () {
                self.processAfterResponse(jForm);
            });
        },

        processResponse: function (jForm, rawResponse) {
            var response = (typeof rawResponse !== 'object') ? JSON.parse(rawResponse) : rawResponse,
                isSuccess = response.success,
                firstMessage = response.messages[0];

            if (isSuccess) {
                if (this.onSendSuccess() !== false) {
                    this.showSuccessMessage(jForm, firstMessage);
                }
            } else {
                if (this.onSendError() !== false) {
                    this.showErrorMessage(jForm, firstMessage);
                }
            }
        }
    });
});