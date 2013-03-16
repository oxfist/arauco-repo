Configuring the app
===================
Follow the steps below in order to get the app working correctly:

1) Download Composer
--------------------
    curl -s https://getcomposer.org/installer | php
    
2) Install vendor bundles
-------------------------
    php composer.phar install

3) Check system config
----------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

4) Configure permissions
------------------------
Set `app/cache` and `app/logs` permissions according to the [manual][1].


4) Configure database
---------------------
Modify `app/config/parameters.yml` in order to create the database for the app, then run:

    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force

6) Replace Twitter Bootstrap files
----------------------------------
    cp _javascripts.html.twig vendor/braincrafted/bootstrap-bundle/Braincrafted/BootstrapBundle/Resources/views/
    cp stylesheets.html.twig vendor/braincrafted/bootstrap-bundle/Braincrafted/BootstrapBundle/Resources/views/
    cp bootstrap.css vendor/braincrafted/bootstrap-bundle/Braincrafted/BootstrapBundle/Resources/public/css/

7) Dump and install assets
--------------------------
    php app/console assetic:dump
    php app/console assets:install --symlink

With this the app should run with no trouble at `localhost/path/to/app/`. If any error is displayed, clear cache with `php app/console cache:clear`.

[1]:  http://symfony.com/doc/2.1/book/installation.html#configuration-and-setup
