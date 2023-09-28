define([
    "jquery", "Magento_Customer/js/customer-data"
], function($, customerData) {
    "use strict";
    return function (config, element) {
        var hobby = customerData.get('customer')().hobby;
        if (typeof (hobby) === "undefined") {
            customerData
                .reload('customer')
                .then(function() {
                    const hobby = customerData.get('customer')().hobby;
                    if (hobby) {
                        $(element).text(' (' + hobby + ')');
                    }
                });
        }
    };
});