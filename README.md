Cameleon
========

A simple MVC style Web application framework utilizing the Bootstrap frontend framework from Twitter, Inc.

The base files are `config.php`, `index.php` and `controller.php`.
`config.php` is where we store the site's configuration details. The `index.php` provides the site's overall html template and `index.php`'s business logic is done inside `controller.php`.

The `pages` directory is where the site's page specific content is stored. A function in the `controller.php` will load the page specific content based on the request uri - this requires some modification of Web server to allow PHP to handle the urls. Each page's business logic is stored in `resources/php/controllers`.

@author Jason Favrod <lakona808@gmail.com>

@version 0.1
