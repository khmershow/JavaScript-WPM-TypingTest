<?PHP
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
	$start_time=0;
	if(isset($_POST["startTime"])){
		$start_time=$_POST["startTime"];
	}
	if(isset($_POST["vstart"])){
		$time_start=microtime(true);
		$readonly="";
		$welcome="";
		$les_text=file_get_contents( "typingtext/0/0.txt" );
	}
	if(isset($_POST["done"])){
		$les_text=file_get_contents( "typingtext/0/0.txt" );
		$user_text=str_replace("\r\n","",$_POST["user_text"]); 
		$user_text=str_replace("\n","",$user_text);
		$total_time=microtime(true)-$start_time;
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
<!DOCTYPE html>
<html>
<head>
	<title>Typing Test Alpha 0.0.1</title> 
    <script type="text/javascript" src="timer.js"></script>
    <script type="text/javascript" src="checker.js"></script>
    <script type="text/javascript" src="copyPaste.js"></script>
    <script type="text/javascript" src="htmlOverlay.js"></script>
	<script type="text/javascript"> 
		var startClicked = <?PHP echo (isset($_POST['vstart']))?"true":"false"; ?>;
		if (startClicked==true){
			InitTimer();
			textCorrect();
		}
		
		var message="Sorry, right-click has been disabled"; 
		function clickIE() {if (document.all) {(message);return false;}} 
		function clickNS(e) {if 
		(document.layers||(document.getElementById&&!document.all)) { 
		if (e.which==2||e.which==3) {(message);return false;}}} 
		if (document.layers) 
		{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;} 
		else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;} 
		document.oncontextmenu=new Function("return false") 
	</script> 
</head>
<body onLoad="">
    <div class="ac">
        <form method='post' action="test.php">
        <br />	
        
             <?php if(isset($_POST["done"])){ ?> 
          						
                <table width="449" cellpadding="6" cellspacing="0" class="ta">
                    <tr>
                        <th width="162" class="th" style="width: 10%"><div align="left">Parameter</div></th>
                        <th width="131" class="th" style="width: 10%"><div align="left">Your result</div></th>
                    </tr>
                    <tr> 
                        <td class="td"><b>Total Words</b> (#)</td> 
                        <td class="td"><b><?PHP echo $totalWords?></b></td>
                  </tr>
                        <tr>
                        <td class="td"><b>GWPM</b> (gross word per minutes)</td>
                        <td class="td"><b><?PHP echo $wpm?></b></td>
                        </tr>
                        <tr> 
                        <td class="td"><b>Errors</b> (#)</td> 
                        <td class="td"><b><?PHP echo $totalError?></b></td>
                        </tr>
                        <tr>
                        <td class="td"><b>CWPM</b> (correct words per minutes)</td> 
                        <td class="td"><b><?PHP echo $cpm?></b></td>
                        </tr>
                  <tr>
                        <td class="td"><b>Accuracy</b> (%)</td> 
                        <td class="td"><b><?PHP echo $accuracy?></b></td>
                        </tr>
                        
                    <tr></tr>
                      <td>&nbsp;</td>
              </table>
			              
          <?PHP }else{?>
           	    Time remaining:<input id="txt" readonly type="text" value="" border="0" name="disp">
            	<br />
                <textarea id="area1"  onkeydown="reutrn disableCtrlKeyCombination(event)" onKeyUp="return disableCtrlKeyCombination(event);" readonly rows="5" cols="72"><?PHP echo $les_text?>
                </textarea>	
                <br /> 
                <input class="in" type="submit" name="vstart" id="vStart" value="Start Test"/>
                <br /> 
                <textarea id="userText" onKeyDown="return disableCtrlKeyCombination(event); " onKeyUp="diffString1(document.getElementById('area1').value,this.value)"  rows="5" cols="72" name="user_text" <?PHP echo $style_text.$readonly; ?>><?PHP echo $welcome; ?></textarea>
                <div id="textCorrection" style="position: absolute; z-index:1; left: 10px; top: 10px; width:200px; height:100px;">
    			</div>
                <br />  
                <input type="submit" name="done" id="done" value="Done" />
                <input type="hidden" name="startTime" value="<?PHP echo $time_start ?>" />
           <?PHP }?>
      </form>
    </div>
</body>
</html>
 