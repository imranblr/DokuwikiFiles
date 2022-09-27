<html>
<head>
<title> Daily Tasks </title>
<style>
caption {
	caption-side: top;
	font-weight: bold;
	font-size: 1.1em;
}
#tasks {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	border-collapse: collapse;
	width: 80%;
}
#tasks td, #tasks th {
	border: 1px solid #ddd;
	padding: 8px;
}
#tasks th {
	padding-top: 12px;
	padding-bottom: 12px;
<!--	background-color: #4CAF50; -->
	background-color: #3966FC; 
	color: black;
}
.button {
<!--	background-color: #4CAF50; -->
	background-color: #3966FC; 
	border: none;
	color: black;
	padding: 12px 24px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: inherit;
	margin: 4px 2px;
	cursor: pointer;
}
.select {
	outline: none;
	-webkit-appearance: none;
	display: inline-block;
	width: 180px;
	line-height: normal;
	padding: 12px 24px;
	margin: 4px 2px;
	transition: border-color 0.2s;
	border: none;
	font-family: inherit;
	font-size: inherit;
}
</style>
</head>
<body>
<?php

 $users = array("admin", "user1", "user2", "user3");
 $user = $_GET['user'];
 
if (in_array($user, $users)){
	echo '<h4 style="text-align:left;">'; echo "Welcome " . $user . " !"; echo '</h4>';
	}
	else {
	echo '<h2 style="text-align:center;">'; echo "Sorry " . $user . ", You're not Authorized"; echo '</h2>';
	exit ();
}
 $url = "http://";
 $url .= $_SERVER['SERVER_NAME'];
 $url .= $_SERVER['PHP_SELF'];
 $url .= "?user=";
 $url .= $user;
    
 date_default_timezone_set("Asia/Qatar");
 $date = date("Y-m-d");
 $today =  date("l");       
 $nw_id = "Networker Backup Status";
 $cv_id = "CommVault Backup Status";
 $sy_id = "Symantec BackupExec Status";
 $aw_id = "AirWatch DBBackup Status";
 $sd_id = "Symantec Antivirus Definitions Status";
 $ly_id = "New User Accounts Lync Status";
 $rf_id = "RightFax HP3PAR Replication Status";


if ( $today != 'Sunday' && $today != 'Monday' ) {
	$sdSubmit = 'disabled';
	$lySubmit = 'disabled';
	$rfSubmit = 'disabled';
	}

$myfile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "r") or die("Unable to open file!");
       
while(!feof($myfile)) {
	$fileEntry=fgets($myfile);
	
	if(strpos($fileEntry, $sd_id) !== false) {
	        $sdSubmit = 'disabled';
	        preg_match("/(USER1|USER2|USER3)/", $fileEntry, $sdEMatch);
	        $sdEngineer = $sdEMatch[0];
	
	        preg_match("/(Success|Failed)/", $fileEntry, $sdSMatch);
	        $sdStatus = $sdSMatch[0];
	
	        preg_match("/Remarks ->(.*)/", $fileEntry, $sdMMatch);
	        $sdMsg = $sdMMatch[1];
	        }
	elseif(strpos($fileEntry, $ly_id) !== false) {
	        $lySubmit = 'disabled';
	        preg_match("/(USER1|USER2|USER3)/", $fileEntry, $lyEMatch);
	        $lyEngineer = $lyEMatch[0];
	
	        preg_match("/(Success|Failed)/", $fileEntry, $lySMatch);
	        $lyStatus = $lySMatch[0];
	
	        preg_match("/Remarks ->(.*)/", $fileEntry, $lyMMatch);
	        $lyMsg = $lyMMatch[1];
	        }
        elseif(strpos($fileEntry, $rf_id) !== false) {
                $rfSubmit = 'disabled';
                preg_match("/(USER1|USER2|USER3)/", $fileEntry, $rfEMatch);
                $rfEngineer = $rfEMatch[0];

                preg_match("/(Success|Failed)/", $fileEntry, $rfSMatch);
                $rfStatus = $rfSMatch[0];

                preg_match("/Remarks ->(.*)/", $fileEntry, $rfMMatch);
                $rfMsg = $rfMMatch[1];
                }
        elseif ( $sdSubmit != 'disabled' && $lySubmit != 'disabled' && $rfSubmit != 'disabled' ) {
                reset_weekly_var();
        	}
	
	if(strpos($fileEntry, $date) !== false) {
		if(strpos($fileEntry, $nw_id) !== false) {
			$nwSubmit = 'disabled';
			preg_match("/(USER1|USER2|USER3)/", $fileEntry, $nwEMatch);
			$nwEngineer = $nwEMatch[0];

			preg_match("/(Success|Failed)/", $fileEntry, $nwSMatch);
			$nwStatus = $nwSMatch[0];
			
			preg_match("/Remarks ->(.*)/", $fileEntry, $nwMMatch);
			$nwMsg = $nwMMatch[1];
			}
		elseif (strpos($fileEntry, $cv_id) !== false) {
			$cvSubmit = 'disabled';
			preg_match("/(USER1|USER2|USER3)/", $fileEntry, $cvEMatch);
			$cvEngineer = $cvEMatch[0];
			
			preg_match("/(Success|Failed)/", $fileEntry, $cvSMatch);
			$cvStatus = $cvSMatch[0];

                        preg_match("/Remarks ->(.*)/", $fileEntry, $cvMMatch);
                        $cvMsg = $cvMMatch[1];
			}
                elseif (strpos($fileEntry, $sy_id) !== false) {
                        $sySubmit = 'disabled';
                        preg_match("/(USER1|USER2|USER3)/", $fileEntry, $syEMatch);
                        $syEngineer = $syEMatch[0];

                        preg_match("/(Success|Failed)/", $fileEntry, $sySMatch);
                        $syStatus = $sySMatch[0];

                        preg_match("/Remarks ->(.*)/", $fileEntry, $syMMatch);
                        $syMsg = $syMMatch[1];
                        }
                elseif (strpos($fileEntry, $aw_id) !== false) {
                        $awSubmit = 'disabled';
                        preg_match("/(USER1|USER2|USER3)/", $fileEntry, $awEMatch);
                        $awEngineer = $awEMatch[0];

                        preg_match("/(Success|Failed)/", $fileEntry, $awSMatch);
                        $awStatus = $awSMatch[0];

                        preg_match("/Remarks ->(.*)/", $fileEntry, $awMMatch);
                        $awMsg = $awMMatch[1];
                        }
	}
	else {
		reset_var();
	}
}
   
 fclose($myfile);

if (isset($_POST['nwSubmission']) && $nwSubmit != 'disabled') {
	$nwEngineer = $_POST['nw_engineer'];
	$nwStatus = $_POST['nw_status'];
	$nwMsg = $_POST['nwMsg'];
	$nwMsg = preg_replace("/[\n\r]/","|", $nwMsg);
	if ($nwEngineer != '' && $nwStatus != ''){
		$myString =  date("Y-m-d h:i:s A");
		$myString .= " - " . $nw_id . " -> ";
		$myString .= $nwStatus ;
		$myString .= " : Verified by -> " ;
		$myString .= $nwEngineer ;
		$myString .= " : Remarks -> ";
		$myString .= $nwMsg ;
		
		$myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
		fwrite($myFile, $myString);
		fwrite($myFile, "\n");
		fclose($myFile);
		$nwSubmit = 'disabled';
	}
}

if (isset($_POST['nwSubmission'])) {
	header('Location:' . $url);
	exit; 
	}

if (isset($_POST['cvSubmission']) && $cvSubmit != 'disabled') {
	$cvEngineer = $_POST['cv_engineer'];
	$cvStatus = $_POST['cv_status'];
	$cvMsg = $_POST['cvMsg'];
	$cvMsg = preg_replace("/[\n\r]/","|", $cvMsg);
	if ($cvEngineer != '' && $cvStatus != '')
        {
		$myString =  date("Y-m-d h:i:s A");
		$myString .= " - " . $cv_id . " -> ";
		$myString .= $cvStatus ;
		$myString .= " : Verified by -> " ;
		$myString .= $cvEngineer ;
		$myString .= " : Remarks -> ";
		$myString .= $cvMsg ;
		             
		$myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
		fwrite($myFile, $myString);
		fwrite($myFile, "\n");
		fclose($myFile);
		$cvSubmit = 'disabled';
	}
	}

if (isset($_POST['cvSubmission'])) {
	header('Location:' . $url);
	exit();
	}

if (isset($_POST['sySubmission']) && $sySubmit != 'disabled') {
        $syEngineer = $_POST['sy_engineer'];
        $syStatus = $_POST['sy_status'];
        $syMsg = $_POST['syMsg'];
        $syMsg = preg_replace("/[\n\r]/","|", $syMsg);
        if ($syEngineer != '' && $syStatus != '')
        {
                $myString =  date("Y-m-d h:i:s A");
                $myString .= " - " . $sy_id . " -> ";
                $myString .= $syStatus ;
                $myString .= " : Verified by -> " ;
                $myString .= $syEngineer ;
                $myString .= " : Remarks -> ";
                $myString .= $syMsg ;

                $myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
                fwrite($myFile, $myString);
                fwrite($myFile, "\n");
                fclose($myFile);
                $sySubmit = 'disabled';
        }
        }

if (isset($_POST['sySubmission'])) {
        header('Location:' . $url);
        exit();
        }

if (isset($_POST['awSubmission']) && $awSubmit != 'disabled') {
        $awEngineer = $_POST['aw_engineer'];
        $awStatus = $_POST['aw_status'];
        $awMsg = $_POST['awMsg'];
        $awMsg = preg_replace("/[\n\r]/","|", $awMsg);
        if ($awEngineer != '' && $awStatus != '')
        {
                $myString =  date("Y-m-d h:i:s A");
                $myString .= " - " . $aw_id . " -> ";
                $myString .= $awStatus ;
                $myString .= " : Verified by -> " ;
                $myString .= $awEngineer ;
                $myString .= " : Remarks -> ";
                $myString .= $awMsg ;

                $myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
                fwrite($myFile, $myString);
                fwrite($myFile, "\n");
                fclose($myFile);
                $awSubmit = 'disabled';
        }
        }

if (isset($_POST['awSubmission'])) {
        header('Location:' . $url);
        exit();
        }

if (isset($_POST['sdSubmission']) && $sdSubmit != 'disabled') {
        $sdEngineer = $_POST['sd_engineer'];
        $sdStatus = $_POST['sd_status'];
        $sdMsg = $_POST['sdMsg'];
        $sdMsg = preg_replace("/[\n\r]/","|", $sdMsg);
        if ($sdEngineer != '' && $sdStatus != '')
        {
                $myString =  date("Y-m-d h:i:s A");
                $myString .= " - " . $sd_id . " -> ";
                $myString .= $sdStatus ;
                $myString .= " : Verified by -> " ;
                $myString .= $sdEngineer ;
                $myString .= " : Remarks -> ";
                $myString .= $sdMsg ;

                $myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
                fwrite($myFile, $myString);
                fwrite($myFile, "\n");
                fclose($myFile);
                $sdSubmit = 'disabled';
        }
        }

if (isset($_POST['sdSubmission'])) {
        header('Location:' . $url);
        exit();
        }

if (isset($_POST['lySubmission']) && $lySubmit != 'disabled') {
        $lyEngineer = $_POST['ly_engineer'];
        $lyStatus = $_POST['ly_status'];
        $lyMsg = $_POST['lyMsg'];
        $lyMsg = preg_replace("/[\n\r]/","|", $lyMsg);
        if ($lyEngineer != '' && $lyStatus != '')
        {
                $myString =  date("Y-m-d h:i:s A");
                $myString .= " - " . $ly_id . " -> ";
                $myString .= $lyStatus ;
                $myString .= " : Verified by -> " ;
                $myString .= $lyEngineer ;
                $myString .= " : Remarks -> ";
                $myString .= $lyMsg ;

                $myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
                fwrite($myFile, $myString);
                fwrite($myFile, "\n");
                fclose($myFile);
                $lySubmit = 'disabled';
        }
        }

if (isset($_POST['lySubmission'])) {
        header('Location:' . $url);
        exit();
        }

if (isset($_POST['rfSubmission']) && $rfSubmit != 'disabled') {
        $rfEngineer = $_POST['rf_engineer'];
        $rfStatus = $_POST['rf_status'];
        $rfMsg = $_POST['rfMsg'];
        $rfMsg = preg_replace("/[\n\r]/","|", $rfMsg);
        if ($rfEngineer != '' && $rfStatus != '')
        {
                $myString =  date("Y-m-d h:i:s A");
                $myString .= " - " . $rf_id . " -> ";
                $myString .= $rfStatus ;
                $myString .= " : Verified by -> " ;
                $myString .= $rfEngineer ;
                $myString .= " : Remarks -> ";
                $myString .= $rfMsg ;

                $myFile = fopen("/opt/DokuWiki/Tasks/Logs/daily_tasks.log", "a") or die("Unable to open file!");
                fwrite($myFile, $myString);
                fwrite($myFile, "\n");
                fclose($myFile);
                $rfSubmit = 'disabled';
        }
        }

if (isset($_POST['rfSubmission'])) {
        header('Location:' . $url);
        exit();
        }


function reset_var(){
        $nwSubmit = '';
        $nwEngineer = '';
        $nwStatus = '';

        $cvSubmit = '';
        $cvEngineer = '';
        $cvStatus = '';

        $sySubmit = '';
        $syEngineer = '';
        $syStatus = '';

        $awSubmit = '';
        $awEngineer = '';
        $awStatus = '';
	}
   
function reset_weekly_var(){
        $sdSubmit = '';
        $sdEngineer = '';
        $sdStatus = '';

        $lySubmit = '';
        $lyEngineer = '';
        $lyStatus = '';

	$rfSubmit = '';
        $rfEngineer = '';
        $rfStatus = '';

	}

?>
	
	<form method="post" action="<?php  echo $_SERVER['PHP_SELF'] . "?user=" . $user;?>">
	 <table id=tasks align="center">
	  <caption><?php echo $today . "'s "; ?>Task Sheet</caption>

	  <tr>&emsp;&emsp;&emsp;&emsp;</tr>

	  <tr>
		<th>Task No. #</th>
		<th>Task Details</th>
		<th>Execution Time</th>
		<th>Task Owner</th>
		<th>Task Status</th>
		<th colspan="2">Remarks</th>
		<th>Submission</th>
	  </tr>

	  <tr><td colspan=8 align=center bgcolor="#9DADFF"><b>Daily Tasks</b> (To Be Performed Everyday)</td></tr> 

	  <tr>
		<td> 1. </td>
		<td>Networker Backup Jobs Status Check </td>
		<td>From 6AM until 12PM</td>
		<td>
		<select name="nw_engineer" id="nw_engineer" class="select" <?php echo $nwSubmit; ?>>
		<option value="">Select Engineer</option>
		<option value="USER1"   <?= $nwEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
		<option value="USER2"   <?= $nwEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
		<option value="USER3"   <?= $nwEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
		</select>
		</td>
		<td>
		<select name="nw_status" id="nw_status" class="select" <?php echo $nwSubmit; ?>>
		<option value="">Select Status</option>
		<option value="Success" <?= $nwStatus == "Success" ? 'selected' : '' ?>>Success</option>
		<option value="Failed" <?= $nwStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
		</select>
		</td>
		<td colspan=2 align=center><textarea name="nwMsg" rows=2 cols=25 maxlength=50 <?= $nwSubmit == "disabled" ? 'readonly' : '' ?>><?php echo $nwMsg; ?></textarea></td>
		<td colspan="2">
		<input type="submit" name="nwSubmission" value="Submit" class="button" <?php echo $nwSubmit; ?> >
		</td>
	  </tr>

	  <tr>
		<td> 2. </td>
		<td>CommVault Backup Jobs Status Check </td>
		<td>From 6AM until 12PM</td>
		<td>
		<select name="cv_engineer" id="cv_engineer" class="select" <?php echo $cvSubmit; ?>>
		<option value="">Select Engineer</option>
		<option value="USER1"   <?= $cvEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
		<option value="USER2"   <?= $cvEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
		<option value="USER3"   <?= $cvEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
		</select>
		</td>
		<td>
		<select name="cv_status" id="cv_status"  class="select" <?php echo $cvSubmit; ?>>
		<option value="">Select Status</option>
		<option value="Success" <?= $cvStatus == "Success" ? 'selected' : '' ?>>Success</option>
		<option value="Failed" <?= $cvStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
		</select>
		</td>
		<td colspan=2 align=center><textarea name="cvMsg" rows=2 cols=25 maxlength=50 <?= $cvSubmit == "disabled" ? 'readonly' : '' ?>><?php echo $cvMsg; ?></textarea></td>
		<td colspan="2">
		<input type="submit" name="cvSubmission" value="Submit" class="button" <?php echo $cvSubmit; ?> >
		</td>
	  </tr>

          <tr>
                <td> 3. </td>
                <td>Symantec BackupExec Jobs for Exchange</td>
                <td>From 6AM until 12PM</td>
                <td>
                <select name="sy_engineer" id="sy_engineer" class="select" <?php echo $sySubmit; ?>>
                <option value="">Select Engineer</option>
                <option value="USER1"   <?= $syEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
                <option value="USER2"   <?= $syEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
                <option value="USER3"   <?= $syEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
                </select>
                </td>
                <td>
                <select name="sy_status" id="sy_status"  class="select" <?php echo $sySubmit; ?>>
                <option value="">Select Status</option>
                <option value="Success" <?= $syStatus == "Success" ? 'selected' : '' ?>>Success</option>
                <option value="Failed" <?= $syStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
                </select>
                </td>
                <td colspan=2 align=center><textarea name="syMsg" rows=2 cols=25 maxlength=50 <?= $sySubmit == "disabled" ? 'readonly' : '' ?>><?php echo $syMsg; ?></textarea></td>
                <td colspan="2">
                <input type="submit" name="sySubmission" value="Submit" class="button" <?php echo $sySubmit; ?> >
                </td>
          </tr>

          <tr>
                <td> 4. </td>
                <td>AirWatch DB Backups Status Check</td>
                <td>From 6AM until 12PM</td>
                <td>
                <select name="aw_engineer" id="aw_engineer" class="select" <?php echo $awSubmit; ?>>
                <option value="">Select Engineer</option>
                <option value="USER1"   <?= $awEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
                <option value="USER2"   <?= $awEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
                <option value="USER3"   <?= $awEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
                </select>
                </td>
                <td>
                <select name="aw_status" id="aw_status"  class="select" <?php echo $awSubmit; ?>>
                <option value="">Select Status</option>
                <option value="Success" <?= $awStatus == "Success" ? 'selected' : '' ?>>Success</option>
                <option value="Failed" <?= $awStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
                </select>
                </td>
                <td colspan=2 align=center><textarea name="awMsg" rows=2 cols=25 maxlength=50 <?= $awSubmit == "disabled" ? 'readonly' : '' ?>><?php echo $awMsg; ?></textarea></td>
                <td colspan="2">
                <input type="submit" name="awSubmission" value="Submit" class="button" <?php echo $awSubmit; ?> >
                </td>
          </tr>

	  <tr><td colspan=8 align=center bgcolor="#9DADFF"><b>Weekly Tasks</b> (To Be Performed on Sunday/Monday)</td></tr> 

          <tr>
                <td> 1. </td>
                <td>Update Symantec Antivirus Definitions on LAN/WAN1/WAN2/EXCHANGE</td>
                <td>From 6AM Sunday until 12PM Monday</td>
                <td>
                <select name="sd_engineer" id="sd_engineer" class="select" <?php echo $sdSubmit; ?>>
                <option value="">Select Engineer</option>
                <option value="USER1"   <?= $sdEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
                <option value="USER2"   <?= $sdEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
                <option value="USER3"   <?= $sdEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
                </select>
                </td>
                <td>
                <select name="sd_status" id="sd_status"  class="select" <?php echo $sdSubmit; ?>>
                <option value="">Select Status</option>
                <option value="Success" <?= $sdStatus == "Success" ? 'selected' : '' ?>>Success</option>
                <option value="Failed" <?= $sdStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
                </select>
                </td>
                <td colspan=2 align=center><textarea name="sdMsg" rows=2 cols=25 maxlength=50 <?= $sdSubmit == "disabled" ? 'readonly' : '' ?>><?php echo $sdMsg; ?></textarea></td>
                <td colspan="2">
                <input type="submit" name="sdSubmission" value="Submit" class="button" <?php echo $sdSubmit; ?> >
                </td>
          </tr>

          <tr>
                <td> 2. </td>
                <td>Enable Lync for Newly Created User Accounts</td>
                <td>From 6AM Sunday until 12PM Monday</td>
                <td>
                <select name="ly_engineer" id="ly_engineer" class="select" <?php echo $lySubmit; ?>>
                <option value="">Select Engineer</option>
                <option value="USER1"   <?= $lyEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
                <option value="USER2"   <?= $lyEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
                <option value="USER3"   <?= $lyEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
                </select>
                </td>
                <td>
                <select name="ly_status" id="ly_status"  class="select" <?php echo $lySubmit; ?>>
                <option value="">Select Status</option>
                <option value="Success" <?= $lyStatus == "Success" ? 'selected' : '' ?>>Success</option>
                <option value="Failed" <?= $lyStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
                </select>
                </td>
                <td colspan=2 align=center><textarea name="lyMsg" rows=2 cols=25 maxlength=50 <?= $lySubmit == "disabled" ? 'readonly' : '' ?>><?php echo $lyMsg; ?></textarea></td>
                <td colspan="2">
                <input type="submit" name="lySubmission" value="Submit" class="button" <?php echo $lySubmit; ?> >
                </td>
          </tr>

          <tr>
                <td> 3. </td>
                <td>RightFax HP3PAR Replication Check</td>
                <td>From 6AM Sunday until 12PM Monday</td>
                <td>
                <select name="rf_engineer" id="rf_engineer" class="select" <?php echo $rfSubmit; ?>>
                <option value="">Select Engineer</option>
                <option value="USER1"   <?= $rfEngineer == "USER1" ? 'selected' : '' ?>>USER1</option>
                <option value="USER2"   <?= $rfEngineer == "USER2" ? 'selected' : '' ?>>USER2</option>
                <option value="USER3"   <?= $rfEngineer == "USER3" ? 'selected' : '' ?>>USER3</option>
                </select>
                </td>
                <td>
                <select name="rf_status" id="rf_status"  class="select" <?php echo $rfSubmit; ?>>
                <option value="">Select Status</option>
                <option value="Success" <?= $rfStatus == "Success" ? 'selected' : '' ?>>Success</option>
                <option value="Failed" <?= $rfStatus == "Failed" ? 'selected' : '' ?>>Failed</option>
                </select>
                </td>
                <td colspan=2 align=center><textarea name="rfMsg" rows=2 cols=25 maxlength=50 <?= $rfSubmit == "disabled" ? 'readonly' : '' ?>><?php echo $rfMsg; ?></textarea></td>
                <td colspan="2">
                <input type="submit" name="rfSubmission" value="Submit" class="button" <?php echo $rfSubmit; ?> >
                </td>
          </tr>
	
	 </table>
	</form>

</body>
</html>
