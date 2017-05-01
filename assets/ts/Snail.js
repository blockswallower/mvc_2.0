var Config = (function () {
    function Config() {
        this.APP_VERSION = 0.8;
        this.APP_NAME = "Snail- PHP framework";
        /* Modify this if needed */
        this.URL = 'http://localhost/Snail-MVC/';
    }
    return Config;
}());
function getJson() {
    var xhr = new Xhr();
    xhr.makeRequest("GET", "https://www.reddit.com/r/programming.json", function (failure, data) {
        if (failure) {
            console.log(failure);
            return false;
        }
        console.log(data);
    });
}
var Xhr = (function () {
    function Xhr() {
        this.xhr = new XMLHttpRequest();
    }
    Xhr.prototype.makeRequest = function (method, url, callback) {
        var _this = this;
        this.xhr.open(method, url, true);
        this.xhr.onload = function () {
            callback(null, _this.xhr.response);
        };
        this.xhr.onerror = function () {
            callback(_this.xhr.response);
        };
        this.xhr.send();
    };
    return Xhr;
}());
