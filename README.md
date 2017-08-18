Tangoman JWT Service Symfony Bundle
===================================

**TangoMan JWT Service Symfony Bundle** provides service for encoding / decoding JWT tokens.


How to install
--------------

With composer 

```console
$ composer require tangoman/jwt-bundle
```

Enable the bundle
-----------------

Don't forget to enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new TangoMan\JWTBundle\TangoManJWTBundle(),
    );
}
```

You don't have to add **TangoMan JWTBundle** to the `service.yml` of your project.
**tangoman_jwt** service will load automatically.

How to use
----------

Inside your controller:
**Don't forget the use statement.**

```php
// AppBundle/Controller/SecurityController.php

use TangoMan\JWTBundle\Model\JWT;
```

Inside your action method:

```php
// Get service
$jwtService = $this->get('tangoman_jwt');

// Instantiate new JWT model
$jwt = new JWT();
$jwt->set('email', 'admin@example.org');
$jwt->set('username', 'Admin');
$jwt->setPeriod(new \DateTime(), new \DateTime('+3 days'));

// Encode token
$token = $jwtService->encode($jwt);
```

```php
// Decode token
$jwt = $this->get('tangoman_jwt')->decode($token);
```

Note
====

If you find any bug please report here : [Issues](https://github.com/TangoMan75/JWTBundle/issues/new)

License
=======

Copyrights (c) 2017 Matthias Morin

[![License][license-GPL]][license-url]
Distributed under the GPLv3.0 license.

If you like **TangoMan JWTBundle** please star!
And follow me on GitHub: [TangoMan75](https://github.com/TangoMan75)
... And check my other cool projects.

[tangoman.free.fr](http://tangoman.free.fr)

[license-GPL]: https://img.shields.io/badge/Licence-GPLv3.0-green.svg
[license-MIT]: https://img.shields.io/badge/Licence-MIT-green.svg
[license-url]: LICENSE
