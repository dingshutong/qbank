# How to install QBank

## Requirements

* PHP 5.6 or later
* MySQL 5.x



## Install Symfony and other dependencies using composer

Open the command line and navigate to the folder where application files are copied and run the below command:


```
#!bash

# php composer.phar install

```

## Updating existing application


```
#!bash

# php composer.phar update

```

Notes:
Script may ask to self-update if older than 30 days. Update it.

If you ran out of memory - usual cause is very old vendors which causes code to not merge. To fix, delete the "vendor" directory and run composer install again.

## Clearing Symfony2 cache:

(development environment)

```
#!bash

# php app/console cache:clear 

```

(production environment)

```
#!bash

# php app/console cache:clear --env=prod

```

## Remove all folders found in /web directory and try this:


```
#!bash

# php app/console assets:install web --symlink

```

If symlink command fails then you need to manually run the symlink commands. The command and syntax various across OS, so find the syntax matching your operating system. The following need to be created:


```
#!bash

# mklink /J vendor\symfony\symfony\src\Symfony\Bundle\FrameworkBundle\Resources\public web\bundles\framework
# mklink /J vendor\friendsofsymfony\jsrouting-bundle\FOS\JsRoutingBundle\Resources\public web\bundles\fosjsrouting
# mklink /J vendor\sensio\distribution-bundle\Sensio\Bundle\DistributionBundle\Resources\public web\bundles\sensiodistribution
# mklink /J src\WB\QbankBundle\Resources\public web\bundles\wbqbank
```


## Refreshing js/css assets:


```
#!bash

# php app/console assetic:dump
```


## Update database schemas

This will update your database schemas, make sure the database user account has permissions to change the database tables.


```
#!bash

# php app/console doctrine:schema:update --force
```
