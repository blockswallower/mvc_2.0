function getJson(): void {
    let xhr = new Xhr();

    xhr.makeRequest("GET", "https://www.reddit.com/r/programming.json", (failure, data) => {
        if (failure) {
            console.log(failure);
            return false;
        }

        console.log(data);
    });
}