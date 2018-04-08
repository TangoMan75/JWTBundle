Tangoman JWT Service Symfony Bundle
===================================

**TangoMan JWT Service Symfony Bundle** provides service for encoding / decoding JWT tokens.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require tangoman/jwt-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    // ...

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new TangoMan\JWTBundle\TangoManJWTBundle(),
        );

        // ...
    }
}
```

You don't have to add **TangoMan JWTBundle** to the `service.yml` of your project.
**tangoman_jwt** service will load automatically.

Usage
=====

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

Copyright (c) 2018 Matthias Morin

[![License][license-MIT]][license-url]
Distributed under the MIT license.

If you like **TangoMan JWTBundle** please star!
And follow me on GitHub: [TangoMan75](https://github.com/TangoMan75)
... And check my other cool projects.

[Matthias Morin | LinkedIn](https://www.linkedin.com/in/morinmatthias)

[license-MIT]: https://img.shields.io/badge/Licence-MIT-green.svg
[license-url]: LICENSE
