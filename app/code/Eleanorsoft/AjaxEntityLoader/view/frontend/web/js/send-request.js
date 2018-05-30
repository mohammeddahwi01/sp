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
                var sendTo = [{name: "da", secondName: "net", age:65},{name: "da1", secondName: "net1", age:64}],url = window.location.href;

                resolve(sendTo);
                reject(url);
                /*return storage.get(sendTo,url).done(
                    function (response) {
                        resolve(response);
                    }
                ).fail(
                    function (response) {
                        reject(response);
                    }
                );*/
            });
        }
    }
);