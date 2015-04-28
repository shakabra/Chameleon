Chameleon
========

A simple MVC style Web application framework utilizing the [Bootstrap](http://getbootstrap.com/) frontend framework from Twitter, Inc.

*Chameleon is currently under pre-release development. Version 1.0 coming soon!.*

The base files are `config.php`, `index.php` and `controller.php`.
`config.php` is where we store the site's configuration details.
The `index.php` provides the site's overall html template and calls up
the configuration, and `index.php`'s business logic is done inside
`controller.php`.

The `pages` directory is where the site's page specific content is
stored. A function in `controller.php` will load the page specific
content based on the request URI (this requires modification of the
Webserver to allow PHP to handle the URIs (rewrite rules provided in
.htaccess file)). Each page's business logic should have it's own
controller.

An incomplete guide to [using chameleon](https://lakonacomputers.com/owncloud/public.php?service=files&t=f31cd6e35cce38eb138de2e4975c5d6e) can be found at the following url:
https://lakonacomputers.com/owncloud/public.php?service=files&t=f31cd6e35cce38eb138de2e4975c5d6e.

@author Jason Favrod <lakona808@gmail.com>

@version 0.4
