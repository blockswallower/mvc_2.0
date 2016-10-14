# Snail - PHP Framework

**_Snail_** is a very fast and efficient PHP framework
and contains a lot of optional features like:

  - Helper classes
  - Self developed template engine
  - Easy routing
  - Before runtime script execution
  - Backend security
  - Symfony command-line interface
  - _(Still in development)_ Database migrations
  - _(Still in development)_ Language translator
  - _(Still in development)_ Build in PHP server

# Download
Website link soon!

In the meantime you can download the zip/rar here.
https://github.com/dennisslimmers01/Snail-MVC/

# Requirements

* Composer
* PHP 5.6+
* PDO if using the Database

# Routing

Routing in Snail is very simple. <br>

First thing you have to do is create a view!<br>
[_This can be different in your current IDE_]<br><br>
Right click on **views**, create a new php file and give it a name.<br>
The name you give your view has to be lowercase.<br>

The next thing is creating your controller.<br>
Right click on **controllers** and create a new php file.<br>
The name you give this controller has to be **camelcase** and it has to match the name of your view.<br>
So for example if the name of your view is **_'index.php'_**, your controller has to be called **_'IndexController.php'_**.<br><br>
Basic controller content:<br>
```php
class IndexController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function show() {
        $this->view->show("index");
    }
}
```


The last thing you have to do is add your route to the routes array<br>
Navigate to http/Routes.php. Here you will see the array that contains all the routes

```php
$this->routes = [
    "index" => "IndexController.show",
    "debug" => "DebugController.show",
    "404" => "PageNotFoundController.show",
];
```

Just add the name of your view and the method that renders your view to the routes array.<br>
Now if you try to navigate to for example http://localhost/snail/index <br>
you will get the correct view

# License 

**_Snail - PHP Micro Framework_** is licensed under the Open Source MIT license, so you can use it for any personal or corporate projects! 

Built by Dennis Slimmers and [Bas van der Ploeg](https://www.linkedin.com/in/bas-van-der-ploeg-836830ba)
