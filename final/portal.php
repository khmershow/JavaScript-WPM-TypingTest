<?PHP
$return_json = "{";
switch($_GET['action']) {
	case "score_table":
		$return_json .= "\"request_time\":\"".strtotime("now")."\",";
		$return_json .= "\"table_html\":".json_encode(getScoreTable())."";
	break;
	default:
	break;
}
function getScoreTable() {
	/*Define variables*/
	$totalError=0;
	$total_time=0;
	$char=0;
	$inputChar=0;
	$wpm="Not value";
	$cpm="Not value";
	$accuracy="Not value";
	$readonly='readonly="readonly"';
	$welcome='Press "Start Test"';
	$les_text='Type the text that appears here in the box below.';
	$cor_text=file_get_contents( "typingtext/0/0.txt" );
	$time_start=0;
	$user_text="";
	$start_time=0;
	$error=0;
	/*function to determine the number of errors */
	function GetError($str1,$str2){
		$error=0;
		for($i=0;$i<strlen($str1);$i++){
			if(isset($str2[$i])){
				if($str1[$i] !=$str2[$i])
				$error++;
				} else
			$error++;
		}
		return $error;
	}
	if(isset($_POST["startTime"])){
		$start_time=$_POST["startTime"];
	}
	/* if you hit start, timer starts and text is adjusted */
	if(isset($_POST["vstart"])){
		$time_start=microtime(true);
		$readonly="";
		$welcome="";
		$les_text=file_get_contents( "typingtext/0/0.txt" );
	}
	/* hit done, gets user input, parses to see differences, calculates time taken, runs GetError, calculates the number of words, finds WPM and Correct WPM and accuracy*/
	if(isset($_POST["done"])){
		$les_text=file_get_contents( "typingtext/0/0.txt" );
		$user_text=str_replace("\r\n","",$_POST["user_text"]); 
		$user_text=str_replace("\n","",$user_text);
		$total_time=microtime(true)-$start_time;
		$char=strlen($les_text);
		$inputChar=strlen($user_text);
		$totalError = (GetError($les_text,$user_text));
		$word=substr_count($les_text,' ') + 1;
		$wpm=round(($inputChar/5)/($total_time / 60));
		$cpm=round((($inputChar/5)/($total_time / 60))- $totalError);
		$totalWords = ($word);
		$accuracy=100-round(GetError($les_text,$user_text) * 100 /$char);
		$readonly='readonly="readonly"';			
	}
	$ret_value = "";
	$ret_value .= "<table width='449' cellpadding='6' cellspacing='0' class='ta'>\n";
    $ret_value .= "	<tr>\n";
    $ret_value .= "		<th width='162' class='th' style='width: 10%'><div align='left'>Parameter</div></th>\n";
                        $ret_value .= "<th width='131' class='th' style='width: 10%'><div align='left'>Your result</div></th>";
                    $ret_value .= "</tr>";
                    $ret_value .= "<tr>"; 
                        $ret_value .= "<td class='td'><b>Total Words</b> (#)</td>";
                        $ret_value .= "<td class='td' id='totalWords'><b>" . $totalWords . "</b></td>";
                 	$ret_value .= "</tr>";
                    $ret_value .= "<tr>";
                        $ret_value .= "<td class='td'><b>GWPM</b> (gross word per minutes)</td>";
                        $ret_value .= "<td class='td' id='wpm'><b>" . $wpm . "</b></td>";
                    $ret_value .= "</tr>";
                    $ret_value .= "<tr>"; 
                        $ret_value .= "<td class='td'><b>Errors</b> (#)</td>"; 
                        $ret_value .= "<td class='td' id='totalError'><b>" . $totalError . "</b></td>";
                    $ret_value .= "</tr>";
                    $ret_value .= "<tr>";
                        $ret_value .= "<td class='td'><b>CWPM</b> (correct words per minutes)</td>";
                        $ret_value .= "<td class='td' id='cpm'><b>" . $cpm . "</b></td>";
                    $ret_value .= "</tr>";
                  	$ret_value .= "<tr>";
                        $ret_value .= "<td class='td'><b>Accuracy</b> (%)</td>";
                        $ret_value .= "<td class='td' id='accuracy'><b>" . $accuracy . "</b></td>";
                    $ret_value .= "</tr>";
                    $ret_value .= "<td>&nbsp;</td>";
              $ret_value .= "</table>";
	return $ret_value;
}
echo $return_json."}";
?>
