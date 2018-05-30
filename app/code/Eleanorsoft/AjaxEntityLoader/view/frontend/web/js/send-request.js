define(
    [
        'ko',
        'jquery',
        'mage/storage',
        'mage/translate'
    ],
    function (
        ko,
        $,
        storage,
        $t
    ) {
        'use strict';
        return function(result){
            return  new Promise( function(resolve, reject) {
                var url = window.location.href+"&qty=15";
                return storage.get(url,url).done(
                    function (response) {
                        resolve(response);
                    }
                ).fail(
                    function (response) {
                        reject(response);
                    }
                );
            });
        }
    }
);