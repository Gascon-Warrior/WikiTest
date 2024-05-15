## INSTALL SYMFONY
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
sudo apt install symfony-cli

## INSTALL COMPOSER
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

## INSTALL DEPENDENCIES
run `php composer.phar install`

## INSTALL ORM-PACK
run `php composer.phar require symfony/orm-pack`

## INSTALL MAKER-BUNDLE
run `php composer.phar require --dev symfony/maker-bundle`

## CREATE DATABASE
1. copy .env file
2. rename it .env.local
3. comment line 29
4. replace line 28 with DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
** /!\ replace !ChangeMe! with your user and password and database name /!\ **
run `sudo php bin/console doctrine:database:create`

## MIGRATE
run `sudo php bin/console doctrine:migrations:migrate`

## LOAD FIXTURES
run `sudo php bin/console doctrine:fixtures:load`

## START SERVER
run `symfony server:start`
