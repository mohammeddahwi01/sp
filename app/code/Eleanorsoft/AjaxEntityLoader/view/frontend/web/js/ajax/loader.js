define
(
    [
        'jquery',
        'uiComponent',
        'ko',
        'mage/storage'
    ],
    function ($, Component, ko, storage)
    {
        'use script';

        return Component.extend({
            defaults: {
                qty: null,
                urlProducts: null
            },

            initialize: function () {
                this._super();
                alert(this.urlProducts);
                // this.getProducts();

            },

            getProducts: function () {
                var self = this;

                return storage.post
                (
                    this.urlProducts,
                    ''
                ).done(function (response) {

                }).fail(function (response) {
                    console.log(response)
                });
            }
        });
    }
);