#!/bin/sh
#
#### Define some variables
DATE=`date +%Y-%m-%d`
TODAY="$(date +"%A")"

DIR="/opt/DokuWiki/Tasks/Logs/"
LOGFILE=$DIR
LOGFILE+="daily_tasks.log"
REPORT=$DIR
REPORT+=$DATE
REPORT+="_Daily_Tasks_Report.html"
DWARN="/opt/DokuWiki/Tasks/MailHeader/Dwarn"
DREPORT="/opt/DokuWiki/Tasks/MailHeader/Dreport"

nwID="Networker Backup Status"
cvID="CommVault Backup Status"
syID="Symantec BackupExec Status"
awID="AirWatch DBBackup Status"
sdID="Symantec Antivirus Definitions Status"
lyID="New User Accounts Lync Status"
rfID="RightFax HP3PAR Replication Status"

nwFlag=1
cvFlag=1
syFlag=1
awFlag=1
sdFlag=1
lyFlag=1
rfFlag=1
Flag=1
FlagSum=0

#### Some Functions to create html report
create_report () {
        if [ ! -e "$REPORT" ] ; then
                touch "$REPORT"
                chown apache:apache "$REPORT"
        elif [ ! -w "$REPORT" ] ; then
                echo Cannot write to $REPORT
                exit 1
        fi
                echo "<html>" >> "$REPORT"
                echo "<body>" >> "$REPORT"
                echo "<title>Today's Daily Task Report</title>" >> "$REPORT"
                echo "<table align="center" width="70%">" >> "$REPORT"
                echo "<caption><b> Daily Tasks Report </b></caption>" >> "$REPORT"
                echo "<tr bgcolor="#A7A2A2"><th>Completion Time</th>" >> "$REPORT"
                echo "<th colspan=2>Task Details </th>" >> "$REPORT"
                echo "<th>Status</th>" >> "$REPORT"
                echo "<th>Verified By</th>" >> "$REPORT"
                echo "<th colspan=2>Remarks</th></tr>" >> "$REPORT"
}
update_report () {
        eval string1="$1"
        eval string2="$2"
        eval string3="$3"
        eval string4="$4"
        eval string5="$5"

        if  [ ${string3} =  Success ] ; then
                bgcolor="#59B74D"
        elif [ ${string3} = Failed ] ; then
                bgcolor="#C05A6C"
        else
                bgcolor="#888BBE"
        fi

        echo "<tr align="center" bgcolor=$bgcolor>" >> "$REPORT"
        echo "<td>${string1}</td>" >> "$REPORT"
        echo "<td colspan=2>${string2}</td>" >> "$REPORT"
        echo "<td>${string3}</td>" >> "$REPORT"
        echo "<td>${string4}</td>" >> "$REPORT"
        echo "<td colspan=2>${string5}</td>" >> "$REPORT"
        echo "</tr>" >> "$REPORT"
}
close_report () {
                echo "</table>" >> "$REPORT"
                echo "</body>" >> "$REPORT"
                echo "</html> " >> "$REPORT"

#### Send the Report
                cat "$DREPORT" "$REPORT" | /sbin/sendmail -t

}

#### Read the log file and set flags

while IFS= read line
do
	if  echo "$line" | grep -q "$sdID"   ; then
		sdFlag=0
	elif  echo "$line" | grep -q "$lyID"   ; then
		lyFlag=0
	elif  echo "$line" | grep -q "$rfID"   ; then
		rfFlag=0
	fi

        if echo "$line" | grep -q "$DATE"; then
                if  echo "$line" | grep -q "$nwID"   ; then
                        nwFlag=0
                elif echo "$line" | grep -q "$cvID"   ; then
                        cvFlag=0
                elif echo "$line" | grep -q "$syID"   ; then
                        syFlag=0
                elif echo "$line" | grep -q "$awID"   ; then
                        awFlag=0
                fi
        fi
done <"$LOGFILE"

FlagSum=`expr $nwFlag + $cvFlag + $syFlag + $awFlag`

if [ $FlagSum -gt 0 ]; then
        cat "$DWARN" | /sbin/sendmail -t
	sleep 30m
	
	while IFS= read line
	do
	        if  echo "$line" | grep -q "$sdID"   ; then
                	sdFlag=0
	        elif  echo "$line" | grep -q "$lyID"   ; then
                	lyFlag=0
        	elif  echo "$line" | grep -q "$rfID"   ; then
                	rfFlag=0
        	fi

        	if echo "$line" | grep -q "$DATE"; then
                	if  echo "$line" | grep -q "$nwID"   ; then
                        	nwFlag=0
                	elif echo "$line" | grep -q "$cvID"   ; then
                        	cvFlag=0
                	elif echo "$line" | grep -q "$syID"   ; then
                        	syFlag=0
                	elif echo "$line" | grep -q "$awID"   ; then
                        	awFlag=0
                	fi
        	fi
	done <"$LOGFILE"
fi

#### Create missing entries in the Log file

if  [ $nwFlag -eq $Flag ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$nwID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $cvFlag -eq $Flag ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$cvID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $syFlag -eq $Flag ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$syID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $awFlag -eq $Flag ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$awID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $sdFlag -eq $Flag -a "$TODAY" == "Monday" ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$sdID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $lyFlag -eq $Flag -a "$TODAY" == "Monday" ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$lyID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi

if [ $rfFlag -eq $Flag -a "$TODAY" == "Monday" ]
 then
        myString="$(date +"%Y-%m-%d %r")"
        myString="${myString} - "
        myString=${myString}$rfID
        myString="${myString} -> Missed : Verified by -> None : Remarks -> The task has been missed "
        echo "$myString" >> "$LOGFILE"
fi


if grep -q "$DATE" "$LOGFILE"; then
        create_report

#### Read the log file and record the entries
        while IFS= read line
        do
                if echo "$line" | grep -q "$DATE"; then
                        time=$(echo "$line" | sed -rn 's/.*^([^,]+) - .*/\1/p')
                        task=$(echo "$line" | sed -rn 's/.* - ([^,]+)Status -> .*/\1/p')
                        status=$(echo "$line" | sed -rn 's/.* Status -> ([^,]+): Verified .*/\1/p')
                        eng=$(echo "$line" | sed -rn 's/.*by -> ([^,]+) : Remarks.*/\1/p')
                        remark=$(echo "$line" | sed -rn 's/.*Remarks -> ([^,]+).*/\1/p')

                        update_report "\${time}" "\${task}" "\${status}" "\${eng}" "\${remark}"
                fi
        done <"$LOGFILE"
        close_report
fi

exit
