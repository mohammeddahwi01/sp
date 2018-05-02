/*define(['jquery',
        'uiComponent',
        'ko'
    ],
    function ($, Component, ko) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this._super();
                console.log("asdasdasd");
                alert("asdasdasd");
            }
        });
    }
);*/
define(['jquery'], function ($) {

/*

    return Component.extend({
        defaults: {
            sayhello: "123"
        },
        initObservable: function () {
            alert('initObservable');
            this._super()
                .observe(['sayhello']);
        },
        initialize: function () {
            alert('initialize');
            this._super();
            this.sayhello = "Hello this is content populated with KO!";
        }
    });
*/

    var mageJsComponent = function(config, node)
    {
        config.name="test string";
        config.test="test test";
        console.log(config);
        console.log(node);
        $(node).find('.text-container-help').click(function(){
            $(this).siblings('.hide-par-link').toggle('slow',function(){
                var textContainer = $(this).siblings('.text-container-help');
                if($(this).is(':visible')){
                    textContainer.prev('.icon-link').addClass('icon-link-active');
                    textContainer.prev('.icon-link').removeClass('icon-link');
                }
                else{
                    textContainer.prev('.icon-link-active').addClass('icon-link');
                    textContainer.prev('.icon-link-active').removeClass('icon-link-active');
                }
            });
            return false;
        });
    };

    return mageJsComponent;
});




