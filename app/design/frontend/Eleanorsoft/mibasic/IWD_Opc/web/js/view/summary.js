define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Checkout/js/model/totals',
        'iwdOpcHelper'
    ],
    function ($, ko, Component, totals) {
        'use strict';
        return Component.extend({
            reviewHasFocus: false,
            isLoading: totals.isLoading,
            opened: ko.observable(false),
            reviewFocus: ko.observable(false),
            initialize: function () {
                this._super();
                var self = this;
                this.reviewFocus.subscribe(function (value) {
                    if (value === false) {
                        self.opened(false);
                    }
                });
                return this;
            },
            appendScrollbar: function (element) {
                $(element).scrollbar({
                    "onInit": function (scroll) {
                        scroll.closest('.scroll-wrapper').removeAttr('tabindex');
                    }
                });
            },
            toggleReview: function () {
                this.opened(!this.opened());
            },
            placeOrder: function () {
                $('.iwd_opc_payment_column .iwd_opc_place_order_button.active').click();
            },
            isPlaceOrderActionAllowed: function () {
                return ($('.iwd_opc_payment_column .iwd_opc_place_order_button.active').length > 0);
            }
        });
    }
);
