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

        onSendSuccess: function (jForm) {
            return true;
        },

        prepareFunctions: function (config) {
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
                values[field.name] = field.value;
            });

            return values;
        },

        submitForm: function (form) {
            var self = this,
                jForm = $(form),
                jSubmit = jForm.find(':submit');

            self.clearMessage(jForm);

            if (this.validateForm(jForm)) {
                jSubmit.prop('disabled', true);

                $.post(jForm.attr('action'), this.getFormValues(jForm), function (rawResponse) {
                    var response = JSON.parse(rawResponse),
                        isSuccess = response.success,
                        firstMessage = response.messages[0];

                    if (isSuccess) {
                        jForm[0].reset();
                        self.onSendSuccess(jForm);
                        self.showSuccessMessage(jForm, firstMessage);
                    } else {
                        self.showErrorMessage(jForm, firstMessage);
                    }
                }).fail(function (error) {
                    self.showErrorMessage(jForm, error.responseText);
                }).always(function () {
                    jSubmit.prop('disabled', false);
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
            var jFormSelector = 'form#' + jForm.attr('id'),
                jMessage = $(jFormSelector + ' .message'),
                jMessagesContainer = $(jFormSelector + ' .page.messages'),
                cssClass = 'message message-' + type + ' ' + type;

            jMessage.removeClass();
            jMessage.addClass(cssClass);
            jMessage.find('div').html('<div>' + message + '</div>');
            jMessagesContainer.find('*').show();
            jMessagesContainer.show();
        },

        clearMessage: function (jForm) {
            var jMessage = jForm.find('.message');

            jMessage.find('div').html('');
            jMessage.removeClass();
            jMessage.addClass('message');
        }
    });
});