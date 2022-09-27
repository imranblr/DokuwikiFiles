#!/bin/sh
#
#### Define some variables
HOSTSTATUS="/opt/DokuWiki/Tasks/MailHeader/HostStatus"
TEMP="/opt/DokuWiki/Tasks/MailHeader/Temp"
#HOSTS=(
#	"100.201.10.5"
#	"100.201.147.79"
#)
#
#for i in "${HOSTS[@]}"; do
#    ping -c 1 "$i" > /dev/null 2>&1
#	if [ "$?" -ne 0 ]
#	then
#	    echo "URGENT - $i is not reachable, please check!!!" > $TEMP
#            cat "$HOSTSTATUS" "$TEMP" | /sbin/sendmail -t
#	    rm -rf $TEMP
#	fi
#done

ping -c 1 100.201.10.5 > /dev/null 2>&1
status1=$?
	if [ "$status1" -ne 0 ]
	then
	    echo "URGENT - time.windows.com (100.201.10.5) is not reachable, please check!!!" > $TEMP
	    cat "$HOSTSTATUS" "$TEMP" | /sbin/sendmail -t
	    rm -rf $TEMP
	elif [ "$status1" -eq 0 ]
	then
	    ssh manager@100.201.10.5 ping -c 1 100.201.147.79 > /dev/null 2>&1
	    status2=$?
		if [ "$status2" -ne 0 ] 
        	then
            	    echo "URGENT - The RaspBerry-Pi (100.201.147.79) is not reachable, please check!!!" > $TEMP
            	    cat "$HOSTSTATUS" "$TEMP" | /sbin/sendmail -t
            	    rm -rf $TEMP
        	fi
	fi

exit
