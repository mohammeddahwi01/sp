define(['jquery', 'uiComponent', 'ko', 'mage/storage'], function ($, Component, ko,storage ) {
        'use strict';
        return Component.extend({
            defaults: {
                endResult: ko.observableArray([]),
                counter: 0,
                canMakeRequest: true,
                canMakeRequestNow: true
            },
            initialize: function (config) {
                var self = this;
                console.log(config.qty);
                this.option = config;
                this._super();
                $(window).scroll(function() {
                    if (
                        self.canMakeRequest &&
                        self.canMakeRequestNow &&
                        $(window).scrollTop() === ($(document).height() - $(window).height())
                    ) {
                        self.updateEntityLoader();
                    }
                });
            },
            updateEntityLoader: function () {
                var self = this;
                this.getProducts().then(function () {
                    if (!Object.keys(arguments[0]).length) {
                        self.canMakeRequest = false;
                        console.log('canMakeRequest then',self.canMakeRequest);
                    }

                    $.each(arguments[0], function (key,value) {
                        self.endResult.push(value);
                    });
                    console.log(self.endResult());
                }).catch(
                    function (e) {
                        console.log(e);
                        console.log("error");
                    }
                )
            },
            getProducts: function () {
                var self = this;
                self.canMakeRequestNow = false;
                console.log('self.canMakeRequestNow getProducts',self.canMakeRequestNow)

                return new Promise( function(resolve, reject) {
                    self.counter++;

                    return storage.get(window.location.href+"&p="+self.counter+"&qty="+self.option.qty).done(
                        function (response) {
                            resolve(response);
                        }
                    ).fail(
                        function (response) {
                            reject(response);
                        }
                    ).always(
                        function () {
                            self.canMakeRequestNow = true;
                            console.log('finished');
                            console.log('self.canMakeRequestNow always',self.canMakeRequestNow)
                        }
                    );
                });
            }
        });
    }
);