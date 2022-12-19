# deiak

## Requirements
PHP 7.2.5 (Extensions: ext-ctype, ext-iconv)  
Your php.ini needs to have the date.timezone setting  
Composer: https://getcomposer.org/download/  

## Optional
Symfony 5 recommendations 

## Instalation instructions
cd /var/www  
git clone git@github.com:amorebietakoUdala/deiak.git

sudo apt update
sudo apt install yarn  
composer install  
yarn install  
yarn build  
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log  
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/log  

## Database creation
php bin/console doctrine:database:create  
php bin/console doctrine:migrations:migrate  

## Apache 2.4 Configuration
Edit /etc/apache2/sites-available/000-default.conf  

    Alias /deiak /var/www/deiak/public
    <Directory /var/www/deiak/public>
            AllowOverride All
            Order Allow,Deny
            Allow from All
    </Directory>

    <Directory /var/www/deiak>
        Options FollowSymlinks
    </Directory>
