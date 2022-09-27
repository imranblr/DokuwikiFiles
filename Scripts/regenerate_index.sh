#!/bin/bash
#Purpose : Setting ownership and indexing dokuwiki pages 
#Author : Imran Khan
#Created on : 14-Apr-2016
#Version : V1
#Modifeid : N/A

# Setting ownership
chown -R apache:apache /var/www/dokuwiki

# Clear the search index first and then index all pages
php /var/www/html/dokuwiki/bin/indexer.php -c -q

exit
