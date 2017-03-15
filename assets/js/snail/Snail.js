snail = {};

snail.ajaxUrl = 'http://localhost/Snail-MVC/ajax';

/*
 * returns JSON response from AjaxController
 *
 * for example:
 *
 * snail.ajaxGet('methodName').success(function(data) {
 *      alert(data);
 * });
 */
snail.ajaxGet = function(method, parameters) {
    return $.ajax({
        url: snail.ajaxUrl + '/' + method,
        type: 'GET',
        async: true,
        dataType: "json"
    });
};

/*
 * Sends post request to AjaxController
 *
 * for example:
 *
 * snail.ajaxPost('methodName', dataObject, event);
 *
 * access in AjaxController with 'json_encode($_POST['data']);'
 * NOTE: data should always be a JSON object
 */
snail.ajaxPost = function(method, data, event) {
    $.ajax({
        url: snail.ajaxUrl + '/' + method,
        type: 'POST',
        data: { data : data },
        async: true
    });

    if (!snail.isUndefined(event)) {
        event.preventDefault();
    }
};

/*
 * returns true if given variable is undefined
 */
snail.isUndefined = function(variable) {
    return typeof variable === 'undefined';
};