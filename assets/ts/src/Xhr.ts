class Xhr {
    private xhr = new XMLHttpRequest();

    public makeRequest(method: string, url: string, callback: (failure: any, data?: any) => any): void {
        this.xhr.open(method, url, true);

        this.xhr.onload = () => {
            callback(null, this.xhr.response);
        };

        this.xhr.onerror = () => {
            callback(this.xhr.response);
        };

        this.xhr.send();
    }
}