#!/bin/sh
#
#### Define some variables
DATE=`date +%Y-%m-%d`
DIR="/opt/DokuWiki/Tasks/Logs/"
LOGFILE=$DIR
LOGFILE+="daily_tasks.log"
REPORT=$DIR
REPORT+=$DATE
REPORT+="_Weekly_Report.html"
TEMPSUCCESSFILE="temp_success_file.txt"
TEMPFAILEDFILE="temp_failed_file.txt"
TEMPOTHERSFILE="temp_others_file.txt"
WWARN="/opt/DokuWiki/Tasks/MailHeader/Wwarn"
WREPORT="/opt/DokuWiki/Tasks/MailHeader/Wreport"

#### Some Functions to create html report
create_report () {
        if [ ! -e "$REPORT" ] ; then
                touch "$REPORT"
                chown apache:apache "$REPORT"
                touch "$TEMPSUCCESSFILE"
                touch "$TEMPFAILEDFILE"
                touch "$TEMPOTHERSFILE"
        elif [ ! -w "$REPORT" ] ; then
                echo Cannot write to $REPORT
                exit 1
        fi
                echo "<html>" >> "$REPORT"
                echo "<body>" >> "$REPORT"
                echo "<title>Weekly Tasks Report</title>" >> "$REPORT"
                echo "<table align="center" width="70%">" >> "$REPORT"
                echo "<caption><b>Weekly Consolidated Report</b></caption>" >> "$REPORT"
                echo "<tr bgcolor="#A7A2A2"><th>Completion Time</th>" >> "$REPORT"
                echo "<th colspan=2>Task Details </th>" >> "$REPORT"
                echo "<th>Status</th>" >> "$REPORT"
                echo "<th>Verified By</th>" >> "$REPORT"
                echo "<th colspan=2>Remarks</th></tr>" >> "$REPORT"
}
update_success_report () {
        eval string1="$1"
        eval string2="$2"
        eval string3="$3"
        eval string4="$4"
        eval string5="$5"
        echo "<tr align="center" bgcolor="#72DB68">" >> "$TEMPSUCCESSFILE"
        echo "<td>${string1}</td>" >> "$TEMPSUCCESSFILE"
        echo "<td colspan=2>${string2}</td>" >> "$TEMPSUCCESSFILE"
        echo "<td>${string3}</td>" >> "$TEMPSUCCESSFILE"
        echo "<td>${string4}</td>" >> "$TEMPSUCCESSFILE"
        echo "<td colspan=2>${string5}</td>" >> "$TEMPSUCCESSFILE"
        echo "</tr>" >> "$TEMPSUCCESSFILE"
}
update_failed_report () {
        eval string1="$1"
        eval string2="$2"
        eval string3="$3"
        eval string4="$4"
        eval string5="$5"
        echo "<tr align="center" bgcolor="#DB6868">" >> "$TEMPFAILEDFILE"
        echo "<td>${string1}</td>" >> "$TEMPFAILEDFILE"
        echo "<td colspan=2>${string2}</td>" >> "$TEMPFAILEDFILE"
        echo "<td>${string3}</td>" >> "$TEMPFAILEDFILE"
        echo "<td>${string4}</td>" >> "$TEMPFAILEDFILE"
        echo "<td colspan=2>${string5}</td>" >> "$TEMPFAILEDFILE"
        echo "</tr>" >> "$TEMPFAILEDFILE"
}
update_others_report () {
        eval string1="$1"
        eval string2="$2"
        eval string3="$3"
        eval string4="$4"
        eval string5="$5"
        echo "<tr align="center" bgcolor="#688EDB">" >> "$TEMPOTHERSFILE"
        echo "<td>${string1}</td>" >> "$TEMPOTHERSFILE"
        echo "<td colspan=2>${string2}</td>" >> "$TEMPOTHERSFILE"
        echo "<td>${string3}</td>" >> "$TEMPOTHERSFILE"
        echo "<td>${string4}</td>" >> "$TEMPOTHERSFILE"
        echo "<td colspan=2>${string5}</td>" >> "$TEMPOTHERSFILE"
        echo "</tr>" >> "$TEMPOTHERSFILE"
}
merge_report (){

        if [ -s "$TEMPSUCCESSFILE" ] ; then
                echo "<tr align="center" bgcolor="#D8F9D6">" >> "$REPORT"
                echo "<th colspan=7>Tasks that were Successful</th></tr>" >> "$REPORT"
                cat "$TEMPSUCCESSFILE" >> "$REPORT"
        fi
        if [ -s "$TEMPFAILEDFILE" ] ; then
                echo "<tr align="center" bgcolor="#F9D6D6">" >> "$REPORT"
                echo "<th colspan=7>Tasks that Failed</th></tr>" >> "$REPORT"
                cat "$TEMPFAILEDFILE" >> "$REPORT"
        fi
        if [ -s "$TEMPOTHERSFILE" ] ; then
                echo "<tr align="center" bgcolor="#D6E2F9">" >> "$REPORT"
                echo "<th colspan=7>Tasks that were either Deferred or Not Submitted</th></tr>" >> "$REPORT"
                cat "$TEMPOTHERSFILE" >> "$REPORT"
        fi
        rm -f "$TEMPSUCCESSFILE"
        rm -f "$TEMPFAILEDFILE"
        rm -f "$TEMPOTHERSFILE"
}
close_report () {

                echo "</table>" >> "$REPORT"
                echo "</body>" >> "$REPORT"
                echo "</html> " >> "$REPORT"

#### Send the Report
                cat "$WREPORT" "$REPORT" | /sbin/sendmail -t

}

#### Check if the Daily Tasks Log file exists
if [ -e "$LOGFILE" ] ; then
        sed -i '/^$/d' "$LOGFILE"
        create_report
#### Read the log file and record the entry
        while IFS= read line
        do
                time=$(echo "$line" | sed -rn 's/.*^([^,]+) - .*/\1/p')
                task=$(echo "$line" | sed -rn 's/.* - ([^,]+)Status -> .*/\1/p')
                status=$(echo "$line" | sed -rn 's/.* Status -> ([^,]+): Verified .*/\1/p')
                eng=$(echo "$line" | sed -rn 's/.*by -> ([^,]+) : Remarks.*/\1/p')
                remark=$(echo "$line" | sed -rn 's/.*Remarks -> ([^,]+).*/\1/p')
                if echo "$line" | grep -q "Success"; then
                        update_success_report "\${time}" "\${task}" "\${status}" "\${eng}" "\${remark}"
                elif echo "$line" | grep -q "Failed"; then
                        update_failed_report "\${time}" "\${task}" "\${status}" "\${eng}" "\${remark}"
                elif echo "$line" | grep -qv 'Failed\|Success'; then
                        update_others_report "\${time}" "\${task}" "\${status}" "\${eng}" "\${remark}"
                fi
        done <$LOGFILE
        merge_report
        close_report
else
	cat "$WWARN" | /sbin/sendmail -t
        echo "Logging of Daily Tasks is either disable or the Log file is missing!" 
fi

exit

