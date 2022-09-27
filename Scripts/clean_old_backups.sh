#!/bin/bash
#Purpose : Clean the old backups of Dokuwiki site
#Author : Manager
#Created on : 22-Feb-2016
#Version : V1
#Modifeid : N/A
TIME=`date +%T-%d%b%Y`
CHNGDIR='cd /opt/DokuWiki/Archives'		#Change to site path
LOG=" : Successfully Cleaned"
$CHNGDIR
find . -atime +30 -exec rm -f {} \; && echo $TIME$LOG >> /opt/DokuWiki/Logs/clean.log
