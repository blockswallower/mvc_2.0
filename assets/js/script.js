snail.httpGet('get').success(function(data) {
    if (!snail.isUndefined(data)) {
        console.log(data);
    }
});

