# Create UserBundle

app/console generate:bundle

## Doctrine

app/console doctrine:generate:entity

## Create db

app/console doctrine:database:create

app/console doctrine:schema:create

## DataFixtures

Add to composer.json

"doctrine/doctrine-fixtures-bundle": "2.2.*"

composer.phar update

app/console doctrine:fixtures:load

## Create CatalogBundle

app/console generate:bundle

## Create entity

app/console doctrine:generate:entity

## Create catalog table

app/console doctrine:schema:update --dump-sql

app/console doctrine:schema:update --force

## CRUD

app/console generate:doctrine:crud

## Data fixture

app/console doctrine:fixtures:load

## Security

app/console container:debug  

## Install assets

create file in Resources/public/css/main.css

Simbolic link
app/console assets:install web --symlink

## Access control

app/console debug:router

## Changing schema

app/console doctrine:schema:update --force

app/console doctrine:query:sql "Select * from fc_catalog"

app/console doctrine:fixtures:load

## Use doctrine extensions slugging

app/console doctrine:schema:drop --force

app/console doctrine:schema:create

app/console doctrine:fixtures:load

app/console doctrine:query:sql "Select * from fc_catalog"

## Run in production

app/console cache:clear --env=prod --no-debug

app/console assetic:dump --env=prod --no-debug (assetic not available in symfony 2.8 version)

## Create a service

Run this command to see the services
app/console container:debug  

in service.yml

```
services:
    # name of the new service
    fc_catalog.reporting.catalog_report_manager:
        # path to class that's been registered
        class: FC\CatalogBundle\Reporting\CatalogReportManager
        arguments:
            # string with @ to identify other services that are necessary to run this one
            - "@doctrine.orm.entity_manager"
```

Run this command to see the services
New service is displayed in the list

To get the service
$this->container->get('fc_catalog.reporting.catalog_report_manager');

On app/config/config.yml, on imports, it's possible to register services like this:
```
    - { resource: "@CatalogBundle/Resources/config/services.yml" }
```

Add calls on service.yml
```
services:
    fc_catalog.reporting.catalog_report_manager:
    ...
    calls:
        - ["setLogger", ["@logger"]]
```

By adding the following in the service registered class:
```
use Symfony\Bridge\Monolog\Logger;

public function getAllCatalogs(){
    $this->logInfor("Logging in...downloading report")
}

private $logger; 

public function setLogger(Logger $logger){
    $this->logger = $logger
}

private function logInfo($msg){
    if($this-logger){
        $this->logger->info($msg)
    }
}
```