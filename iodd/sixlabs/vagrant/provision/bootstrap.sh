#!/bin/bash

databaseName="ddp"
sqlSyncPasword="<sync-password>"

provisionWorkingDir="/vagrant/iodd/sixlabs/vagrant/provision"
provisionTemplateDir="$provisionWorkingDir/templates"
provisionTools="$provisionWorkingDir/tools"
ioddPath="/vagrant/iodd/"

# MySQL Setup
echo ".:: Creating Database ::.";
mysql -u root -proot -e "DROP DATABASE IF EXISTS $databaseName"
mysql -u root -proot -e "CREATE SCHEMA IF NOT EXISTS $databaseName";

# Migrate DB
echo ".:: Sycing DB ::.";
gunzip < $ioddPath/migrate-initial.sql.gz | mysql -u root -proot $databaseName;
php $provisionTools/srdb.cli.php -h localhost -u root -p root -s "//downtowndetroit.org" -r "//ddp.dev" -n $databaseName;

# WP Config
if [ -f $provisionTemplateDir/wp-config.php ]; then
    echo ".:: Copying wp-config.php ::.";
    cp $provisionTemplateDir/wp-config.php /var/www/html
fi

# WP Config
if [ -f $provisionTemplateDir/.htaccess ]; then
    echo ".:: Copying .htaccess ::.";
    cp $provisionTemplateDir/.htaccess /var/www/html
fi


echo ".:: sixlabs provision complete! ::.";

art=$'
        d8b        888        888
        Y8P        888        888
                   888        888
.d8888b 888888  888888 8888b. 88888b. .d8888b
88K     888`Y8bd8P\'888    "88b888 "88b88K
"Y8888b.888  X88K  888.d888888888  888"Y8888b.
     X88888.d8""8b.888888  888888 d88P     X88
 88888P\'888888  888888"Y88888888888P"  88888P\'

http://sixlabs.io
'

echo "${art}"