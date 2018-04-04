define([
    'jquery',
    'uiComponent',
    'mage/validation'
], function ($, Component) {
    'use strict';

    return Component.extend({
        initialize: function (config) {
            var self = this;
            this._super();
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
            var self = this;
            var jForm = $(form),
                jSubmit = jForm.find(':submit');

            if (this.validateForm(jForm)) {
                jSubmit.prop('disabled', true);

                $.post(jForm.attr('action'), this.getFormValues(jForm), function (result) {
                    console.log(result);
                }).fail(function (error) {
                    self.showErrorMessage(error.responseText);
                }).always(function () {
                    jForm[0].reset();
                    jSubmit.prop('disabled', false);
                });
            }
        }
    });
});