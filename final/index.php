
<?
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
	$log_text="Not Value";
	$pwd_text="Not Value";
	$totalErrors=0;
	$num_type=0;
	$num=0;
	$time_start=0;
	$total_time=0;
	$char=0;
	$wpm="Not value";
	$cpm="Not value";
	$accuracy="Not value";
	$readonly='readonly="readonly"';
	$welcome='Press button "Start Test"';
	$name="Typist";
	$les_text='Type the text that appears here in the box below.';
	$cor_text=file_get_contents( "typingtext/0/0.txt" );
	
	$user_text="";
	$style_text='id="area2"';
	$was_start=0;
	
	if(isset($_POST["vnumtype"])){
		$num_type=$_POST["vnumtype"];
	}
	if(isset($_POST["vnum"])){
		$num=$_POST["vnum"];
	}
	if(isset($_POST["vstart"])){
		$time_start=$_POST["vstart"];
		
	}
	if(isset($_POST["name"])){
		$name=$_POST["name"];
	}
	if(isset($_POST["was_start"])){
		$was_start=$_POST["was_start"];
	}
	if(isset($_POST["update"])){
		$num_type=$_POST["numtype"];
		$num=$_POST["num"];
	}
	if(isset($_POST["vstart"])){
		$time_start=microtime(true);
		$readonly="";
		$welcome="";
		$style_text="id=\"area3\"";
		$was_start=1;
		$les_text=file_get_contents( "typingtext/0/0.txt" );
	}
	if(isset($_POST["done"])){
		$user_text=str_replace("\r\n","",$_POST["user_text"]); 
		$user_text=str_replace("\n","",$user_text);
		$total_time=microtime(true)-$time_start-1;
		$char=strlen($les_text);
		$word=substr_count($les_text,' ') + 1;
		$word += substr_count($les_text,'.');
		$word += substr_count($les_text,',');
		$word += substr_count($les_text,';');
		$wpm=round(($char/5)/$total_time * 60);
		$cpm=round((($char/5)-$error)/($total_time * 60));
		$totalErrors = GetError($les_text,$user_text);
		$totalWords = ($char/5);
		$accuracy=100-round(GetError($les_text,$user_text) * 100 /$char);
		$time_start=0;
		$readonly='readonly="readonly"';
		$was_start=0;
	}

?>
    

<html>
<head>
	<title>Typing Test Beta 0.0.1</title>
	<script type="text/javascript" src="timer.js"></script>
    <script type="text/javascript" src="checker.js"></script>
    <script type="text/javascript" src="copyPaste.js"></script>
    <script type="text/javascript">
	var startClicked = <?PHP echo (isset($_POST['vstart']))?"true":"false"; ?>;
	</script>
	<script type="text/javascript"> 
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
<body onLoad="detectStart();">
<div id="testDiv"></div>

    <div class="ac">
        <form method='post' action="index.php">
        <br />	
          <?php if(isset($_POST["done"])){ ?> 
                
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
                        <td class="td"><b><?=$error?></b></td>
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
             <?}else{?>
            Time remaining:<input id="txt" readonly type="text" value="" border="0" name="disp">
            
          <br />
                <textarea id="area1"  onkeydown="reutrn disableCtrlKeyCombination(event)" onKeyUp="return disableCtrlKeyCombination(event);" readonly rows="5" cols="72"><?=$les_text?>
                </textarea>	
                <br /> 
                <input class="in" type="submit" name="vstart" value="Start Test"/>
                <br /> 
                <textarea <?PHP echo $style_text.$readonly; ?> id="userText" onKeyDown="return disableCtrlKeyCombination(event); " onKeyUp="diffString1(document.getElementById('area1').value,this.value)"  rows="5" cols="72" name="user_text"><?PHP echo $welcome; ?></textarea>
                
          <br /> 
                <input type="submit" name="done" id="done" value="Done" />
            <input type="hidden" name="was_start" value="<?=$was_start?>" /> 
            <input type="hidden" name="vnum" value="<?=$num?>" /> 
            <input type="hidden" name="vnumtype" value="<?=$num_type?>" /> 
            <input type="hidden" name="vstart" value="<?=$time_start?>" /> 
        <?}?>
      </form>
    </div>
</body>
</html>
