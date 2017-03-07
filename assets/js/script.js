snail.httpGet('get')
    .success(function(data) {
        console.log(data);
    })
    .error(function() {
        console.log('Something went wrong');
    });

