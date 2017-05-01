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
//# sourceMappingURL=Script.js.map