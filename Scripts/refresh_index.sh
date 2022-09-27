#!/bin/bash
#Purpose : Setting ownership and indexing dokuwiki pages 
#Author : Imran Khan
#Created on : 14-Apr-2016
#Version : V1
#Modifeid : N/A

# Setting ownership
chown -R apache:apache /var/www/dokuwiki

# Updating search index by indexing all new or changed pages
php /var/www/html/dokuwiki/bin/indexer.php -q

exit
