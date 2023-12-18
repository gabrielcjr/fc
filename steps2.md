# Create UserBundle

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

# Create CatalogBundle

app/console generate:bundle

# Create entity

app/console doctrine:generate:entity

# Create catalog table

app/console doctrine:schema:update --dump-sql

app/console doctrine:schema:update --force

# CRUD

app/console generate:doctrine:crud

# Data fixture

app/console doctrine:fixtures:load

# Security 

app/console container:debug  

# Install assets

create file in Resources/public/css/main.css

Simbolic link
app/console assets:install web --symlink

# Access control

app/console debug:router

# Changing schema

app/console doctrine:schema:update --force

app/console doctrine:query:sql "Select * from fc_catalog"

app/console doctrine:fixtures:load

# Use doctrine extensions slugging

app/console doctrine:schema:drop --force       

app/console doctrine:schema:create

app/console doctrine:fixtures:load

app/console doctrine:query:sql "Select * from fc_catalog"