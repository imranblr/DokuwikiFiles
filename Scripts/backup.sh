#!/bin/bash
#Purpose : Backup of entire Dokuwiki site data
#Author : Imran Khan
#Created on : 22-Feb-2016
#Version : V1
#Modifeid : N/A

TIME=`date +%I%p-%d%b%Y` 		# This will time stamp
FILENAME=DOC_Backup_$TIME.tar.gz	#Backup file name
CHNGDIR='cd /var/www/html'		#Change to site path
SRCDIR=dokuwiki				#Source Directory
DESTDIR=/opt/DokuWiki/Archives		#Destination to store backup archives
LOG=" : Successfully Backed up Dokuwiki Config Files"
FILENAME2=DOC_DataBackup_$TIME.tar.gz
CHNGDIR2='cd /var/www/dokuwiki'
SRCDIR2=data
LOG2=" : Successfully Backed up Dokuwiki Data Files"

$CHNGDIR
tar -cpzf $DESTDIR/$FILENAME $SRCDIR && echo $TIME$LOG >> /opt/DokuWiki/Logs/backup.log

$CHNGDIR2
tar -cpzf $DESTDIR/$FILENAME2 $SRCDIR2 && echo $TIME$LOG2 >> /opt/DokuWiki/Logs/backup.log

exit
