Chameleon
========

A simple MVC style Web application framework utilizing the [Bootstrap](http://getbootstrap.com/) frontend framework from Twitter, Inc.

The base files are `config.php`, `index.php` and `controller.php`.
`config.php` is where we store the site's configuration details.
The `index.php` provides the site's overall html template.
`index.php`'s business logic is done inside `controller.php`.

The `pages` directory is where the site's page specific content is stored.
A function in `controller.php` will load the page specific content based on the request URI
(this requires modification of the Web server to allow PHP to handle the URIs).
Each page's business logic should be stored in `resources/php/controllers`.

A guide to [using chameleon](https://lakonacomputers.com/owncloud/public.php?service=files&t=f31cd6e35cce38eb138de2e4975c5d6e) can be found at the following url:
https://lakonacomputers.com/owncloud/public.php?service=files&t=f31cd6e35cce38eb138de2e4975c5d6e.

@author Jason Favrod <lakona808@gmail.com>

@version 0.2

Todo: 
