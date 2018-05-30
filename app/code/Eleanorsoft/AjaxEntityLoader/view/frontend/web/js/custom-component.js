define(['jquery', 'uiComponent', 'ko','Eleanorsoft_AjaxEntityLoader/js/send-request'], function ($, Component, ko,result ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Eleanorsoft_AjaxEntityLoader/test-component',
                endResult: 0
            },
            initialize: function () {
                this._super();
                this.updateEntityLoader();
            },
            updateEntityLoader: function () {
                var self = this;
                 result().then(function () {
                     self.endResult  = arguments;
                     console.log(arguments);
                     console.log(self.endResult);
                });
            }
        });
    }
);