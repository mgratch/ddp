#!/bin/bash

databaseName="ddp"
sqlSyncPasword=""
installSqlSync="false";

findReplace="true"
find="//downtowndetroit.org"
replace="//ddp.dev"

provisionWorkingDir="/vagrant/iodd/vagrant/provision"
provisionTemplateDir="$provisionWorkingDir/files"
provisionTools="$provisionWorkingDir/tools"

# MySQL Setup
echo ".:: Creating Database ::.";
mysql -u root -proot -e "DROP DATABASE IF EXISTS $databaseName"
mysql -u root -proot -e "CREATE SCHEMA IF NOT EXISTS $databaseName";

if [ $installSqlSync == "true" ]; then
  echo ".:: Installing DB Sync ::.";
  npm install -g tjay-sql-sync;
fi

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

# DB Sync
if [ -f $provisionTemplateDir/db-sync-config.json ]; then
  echo ".:: Copying db-sync-config.json ::.";
  cp $provisionTemplateDir/db-sync-config.json /home/vagrant
  cd /home/vagrant && sql-sync -c $sqlSyncPasword;
fi

if [ -f $provisionTemplateDir/migrate-initial.sql.gz &&  ]; then
  gunzip < $provisionTemplateDir/migrate-initial.sql.gz | mysql -u root -proot $databaseName
fi

if [ $findReplace == "true" ]; then
  php $provisionTools/srdb.cli.php -h localhost -u root -p root -s $find -r $replace -n $databaseName;
fi

# Move ENV Config
if [ -f $provisionTemplateDir/.env ]; then
  cp $provisionTemplateDir/.env /var/www/html/
fi

# Project Config
if [ -f $provisionWorkingDir/project.sh ]; then
  echo ".:: Project Custom Config ::.";
  exec $provisionWorkingDir/project.sh
fi

echo ".:: Provision complete! ::.";