#FrontEsi

This module allow you to define which route can be cached and a specific expiration time.

You can only use expiration cache. Validation cache must be set in each controller you want to use.

Obviously this module must used in combination with esi tags, using the render_esi tag : {render_esi path="http://your-taget.tld/resource"}

##Installation

```
cd path/to/thelia
git clone https://github.com/thelia-modules/HttpCaching.git local/modules/HttpCaching
```

After that you need to activate the module in Thelia module administration panel.

##Usage

Once activated, your module is ready to use.

You only need a reverse proxy. If you can't install a reverse proxy like Varnish, you can use HttpCache from symfony HttpFoundation component, for this,
edit ```web/index.php``` and uncomment the HttpCache line :

```php
<?php
use Thelia\Core\HttpKernel\HttpCache\HttpCache;

...

$thelia = new Thelia("prod", false);
$thelia = new HttpCache($thelia);
$response = $thelia->handle($request)->prepare($request)->send();

...
```

The module redefined some routes by adding the ```no-cache``` parameter to 1. This routes can't be cached.

##Routing parameters

You can use some parameters in your route for defining the max-age and s-maxage Http header. You can also deactivated the cache for a specific route :

- ```max-age``` : Sets the number of seconds after which the response should no longer be considered fresh. Default 600 (10 minutes)
- ```s-maxage``` : Sets the number of seconds after which the response should no longer be considered fresh by shared caches. Default 600 (10 minutes)
- ```no-cache``` : if set to 1, this route is not cached

routing example :

```
<?xml version="1.0" encoding="UTF-8" ?>

<routes xmlns="http://symfony.com/schema/routing"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://symfony.com/schema/routing http://symfony.com/schema/routing/routing-1.0.xsd">

    <!-- Account -->
    <route id="httpCaching.customer.update.view" path="/account/update" methods="get">
        <default key="_controller">Front\Controller\CustomerController::viewAction</default>
        <default key="_view">account-update</default>
        <default key="no_cache">1</default>
    </route>

    <route id="specific.cache.route" path="/cart_fragment">
        <default key="_controller">Thelia\Controller\Front\DefaultController::noAction</default>
        <default key="_view">fragment/cart</default>
        <default key="max-age">1000</default>
        <default key="s-maxage">60</default>
    </route>
</routes>
```

##Resources

- http://www.mnot.net/cache_docs/ (fr)
- http://tomayko.com/writings/things-caches-do (en)
- http://symfony.com/doc/current/book/http_cache.html#http-cache-introduction (en and fr)



