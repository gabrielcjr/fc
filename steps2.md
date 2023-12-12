# Create Bundle

app/console generate:bundle

# Doctrine

app/console doctrine:generate:entity

# Create db

app/console doctrine:database:create

app/console doctrine:schema:create

# DataFixtures

Add to composer.json

"doctrine/doctrine-fixtures-bundle": "2.2.*"

composer.phar update

app/console doctrine:fixtures:load