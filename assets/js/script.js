snail.ajaxGet('get')
    .success(function(data) {
        console.log(data);
    })
    .error(function() {
        console.log('Something went wrong');
    });

var test = function() {
    data = {
        "test": "value",
        "test2": "value2"
    };

    snail.ajaxPost('post', data);
};
