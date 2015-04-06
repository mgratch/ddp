#!/bin/bash

a2enmod rewrite

echo "zend_extension=xdebug.so
      xdebug.var_display_max_depth = -1
      xdebug.var_display_max_children = -1
      xdebug.var_display_max_data = -1" > /etc/php5/apache2/conf.d/20-xdebug.ini

/etc/init.d/apache2 restart;