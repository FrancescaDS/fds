define(function (){
    'use strict';

    /*con queto si rendono validi tutti i fields nel Magento frontend*/
    var extension = {
        isValid: function () {
            return true;
        }
    };

    return function (target) {
        return target.extend(extension);
    }

});
