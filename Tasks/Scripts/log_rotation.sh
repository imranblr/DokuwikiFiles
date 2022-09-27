#!/bin/bash
#Purpose : Rotate the daily log file once a week
#Author : Imran
#Created on : 13-06-2016
#Version : V1
#Modifeid : N/A

TIME=`date +%T-%d%b%Y`
DATE=`date +%Y-%m-%d`
LOGDIR="/opt/DokuWiki/Tasks/Logs/"
LOGFILE="daily_tasks.log"
CHNGDIR='cd /opt/DokuWiki/Tasks/Archives'             #Change to Archive folder
LOG=" : Successfully Rotated"

$CHNGDIR

mv "$LOGDIR""$LOGFILE" "$DATE"_"$LOGFILE" && echo $TIME$LOG >> /opt/DokuWiki/Tasks/Logs/logs_rotation.log
touch "$LOGDIR""$LOGFILE"
chmod 666 "$LOGDIR""$LOGFILE"
chown apache:apache "$LOGDIR""$LOGFILE"

exit
