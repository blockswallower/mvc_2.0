class Config {
    /**
     * @const {number} APP_VERSION
     * Current application version of Snail
     */
    public APP_VERSION: number;

    /**
     * @const {string} APP_NAME
     * Current application name of Snail
     */
    public APP_NAME: string;

    /**
     * Contains the URl
     * where the Snail application is running on, and will
     * be different depending on your host
     */
    public URL: string;

    constructor() {
        this.APP_VERSION = 0.8;
        this.APP_NAME = "Snail- PHP framework";

        /* Modify this if needed */
        this.URL = 'http://localhost/Snail-MVC/';
    }
}
