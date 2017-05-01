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
//# sourceMappingURL=Xhr.js.map