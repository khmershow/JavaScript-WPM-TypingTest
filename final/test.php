<?PHP
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
?>
<!-- Begin HTML-->
<!DOCTYPE html>
<html>
<head>
	<title>Typing Test Alpha 0.0.1</title> 
    <!--Load outside .js and add click functions and disable right click  -->
    <script type="text/javascript" src="timer.js"></script>
    <script type="text/javascript" src="checker.js"></script>
    <script type="text/javascript" src="copyPaste.js"></script>
    <script type="text/javascript" src="https://is.byu.edu/is/share/BrainHoney/ScormGrader.js"></script>
    <script type="text/javascript"> 
		var startClicked = <?PHP echo (isset($_POST['vstart']))?"true":"false"; ?>;
		if (startClicked==true){
			InitTimer();
		}
		function textClick(){
		var textButton = document.getElementById('userText');
	 	textButton.focus();	
		}
		var doneClicked = <?PHP echo (isset($_POST['done']))?"true":"false"; ?>;
		if (doneClicked==true){
			SetScore(<?PHP echo $cpm ?>);
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
<body onLoad="initializeAPI();">
    <div class="ac">
        <form method='post' action="test.php">
        <br />	
        	<!--forms a table to display when done is clicked -->
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
             <!-- forms the display show anytime prior to done being clicked
             inputText runs disableCtrlKeyCombo to stop cut and paste 
             textCorrection is placed over it and is editted by diffString1
             userText is the input form and calls the disableCtrlKeyCombo,
             also calls diffString to change the color of the text in textCorrection to show incorrect input
             -->			              
          <?PHP }else{?>
           	    Time remaining:<input id="txt" readonly type="text" value="" border="0" name="disp">
            	<br />
                <div id="inputText" style="position:static; width:823px; height:166px;">
                <textarea id="area1"  onkeydown="return disableCtrlKeyCombination(event);" onKeyUp="return disableCtrlKeyCombination(event);"  style="font-family:Arial, Helvetica, sans-serif;" readonly rows="10" cols="133"><?PHP echo $les_text?></textarea>	
                	<div id="textCorrection" style="position:relative ; z-index:999; top:-175px;left:0px; width:inherit; height:inherit; background:white; overflow:auto; border:thin; border-style:solid; border-color:#B4B4B4;">	<?PHP echo $les_text?>
    				</div>
                </div>
                <br /> 
                <input class="in" type="submit" name="vstart" id="vStart" value="Start Test" />
                <input type="submit" name="done" id="done" value="Done" />
                <br /> 
                <textarea id="userText" onKeyDown="return disableCtrlKeyCombination(event); " onKeyUp="diffString1(document.getElementById('area1').value,this.value);" rows="10" cols="100" name="user_text" ><?PHP echo $welcome; ?></textarea>
                <br />  
                
                <input type="hidden" name="startTime" value="<?PHP echo $time_start ?>" />
           <?PHP }?>
      </form>
    </div>
</body>
</html>
 