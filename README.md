# deiak

## Requirements
PHP 7.2.5 (Extensions: ext-ctype, ext-iconv)
Your php.ini needs to have the date.timezone setting
Composer: https://getcomposer.org/download/
Node.js: https://nodejs.org/en/

## Optional
Symfony 5 recommendations 

## Instalation instructions
cd /var/www/html
git clone 

sudo apt install yarn
composer install
yarn install
php bin/console bazinga:js-translation:dump public --format=json --pattern=/translations/{domain}.{_format} --merge-domains
php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
php bin/console doctrine:migrations:migrate
yarn build
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log

## Instalation instructions
