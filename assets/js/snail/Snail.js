snail = {};

snail.ajaxUrl = 'http://localhost:81/Snail-MVC/ajax';

/*
 * @param url
 *
 * returns JSON object from AjaxController
 *
 * for example:
 *
 * snail.httpGet('methodName').success(function(data) {
 *      alert(data)
 * });
 */
snail.httpGet = function(method, parameters) {
    return $.ajax({
        url: snail.ajaxUrl + '/' + method,
        type: 'GET',
        async: true,
        dataType: "json"
    });
};

/*
 * @param variable
 *
 * returns true if given variable is undefined
 */
snail.isUndefined = function(variable) {
    return typeof variable === 'undefined';
};