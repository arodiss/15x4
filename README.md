15x4
====

15x4 is community running free popular science lectures in Kyiv and Kharkiv (Ukraine). More at 15x4.org

### How to run locally

After cloning project from git, you need to install [composer package manager](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
To install required dependencies, do `composer install`
To configure local instance, do `cp app/config/parameters.yml.dist app/config/parameters.yml`. You may want to edit `app/config/parameters.yml` afterwards, especially DB connection credentials
To build project itself, do
```
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
bin/console 15x4:load-fields
bin/console assets:install --symlink
bin/console assetic:dump --env=prod --no-debug
```
To run application as a site, you need to use webserver. You may use whatever you like, but recommended one is Apache2
