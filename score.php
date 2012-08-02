<?php
	$totalError=0;
	$total_time=0;
	$char=0;
	$wpm="Not value";
	$cpm="Not value";
	$accuracy="Not value";
	$readonly='readonly="readonly"';
	$welcome='Press button "Start Test"';
	$les_text='Type the text that appears here in the box below.';
	$cor_text=file_get_contents( "typingtext/0/0.txt" );
	$time_start=0;
	$user_text="";
	$style_text='id="area2"';
	$start_time=0;
	
function _Cmp($a,$b){
		$line1=explode("|",$a);
		$line2=explode("|",$b);
		if ($line1[5] ==$line2[5])
		return 0;
		return ($line1[5] >$line2[5]) ? -1 : 1;
	}
	
	$error=0;
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
if(isset($_POST["done"])){
		$les_text=file_get_contents( "typingtext/0/0.txt" );
		$user_text=str_replace("\r\n","",$_POST["user_text"]); 
		$user_text=str_replace("\n","",$user_text);
		$total_time=microtime(true)-$time_start;
		$char=strlen($les_text);
		$word=substr_count($les_text,' ') + 1;
		$wpm=round(($char/5)/($total_time / 60));
		$cpm=round((($char/5)-$totalError)/($total_time / 60));
		$totalError = (GetError($les_text,$user_text));
		$totalWords = ($word);
		$accuracy=100-round(GetError($les_text,$user_text) * 100 /$char);
		$readonly='readonly="readonly"';			
	}
?>
 
<html>
<head>
	<title></title>
<script type="text/javascript" src="timer.js"></script>
<script type="text/javascript" src="checker.js"></script>
<script type="text/javascript" src="copyPaste.js"></script>
</head>
<body >
<div id="testDiv"></div>
    <div class="ac">
        <form method='post' action="score.php">
        <br />	
                        <table width="449" cellpadding="6" cellspacing="0" class="ta">
                    <tr>
                        <th width="162" class="th" style="width: 10%"><div align="left">Parameter</div></th>
                        <th width="131" class="th" style="width: 10%"><div align="left">Your result</div></th>
                    </tr>
                    <tr> 
                        <td class="td"><b>Total Words</b> (#)</td> 
                        <td class="td"><b><?=$totalWords?></b></td>
                  </tr>
                        <tr>
                        <td class="td"><b>GWPM</b> (gross word per minutes)</td>
                        <td class="td"><b><?=$wpm?></b></td>
                        </tr>
                        <tr> 
                        <td class="td"><b>Errors</b> (#)</td> 
                        <td class="td"><b><?=$totalError?></b></td>
                        </tr>
                        <tr>
                        <td class="td"><b>CWPM</b> (correct words per minutes)</td> 
                        <td class="td"><b><?=$cpm?></b></td>
                        </tr>
                  <tr>
                        <td class="td"><b>Accuracy</b> (%)</td> 
                        <td class="td"><b><?=$accuracy?></b></td>
                  </tr>
                        
                    <tr></tr>
                      <td>&nbsp;</td>
          </table>
          </form>
    </div>
</body>
</html>

