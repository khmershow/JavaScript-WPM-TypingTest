<?PHP
	function _Cmp($a,$b){
		$line1=explode("|",$a);
		$line2=explode("|",$b);
		if ($line1[5] ==$line2[5])
		return 0;
		return ($line1[5] >$line2[5]) ? -1 : 1;
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
	$style_text='id="area2"';
	$start_time=0;

	if(isset($_POST["vstart"])){
		$time_start=microtime(true);
		$readonly="";
		$welcome="";
		$style_text="id=\"area3\"";
		$les_text=file_get_contents( "typingtext/0/0.txt" );
	}
?>
<html>
<head>
	<title>Typing Test Alpha 0.0.2</title>
	<script type="text/javascript" src="timer.js"></script>
    <script type="text/javascript" src="checker.js"></script>
    <script type="text/javascript" src="copyPaste.js"></script>
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
<body onLoad="detectStart(); ">
<div id="testDiv"></div>
    <div class="ac">
        <form method='post' action="wpmtest.php">
        <br />	
            Time remaining:<input id="txt" readonly type="text" value="" border="0" name="disp">
            
          <br />
                <textarea id="area1"  onkeydown="reutrn disableCtrlKeyCombination(event)" onKeyUp="return disableCtrlKeyCombination(event);" readonly rows="5" cols="72"><?=$les_text?>
                </textarea>	
                <br /> 
                <br /> 
                <textarea <?PHP echo $style_text.$readonly; ?> id="userText" onKeyDown="return disableCtrlKeyCombination(event); " onKeyUp="diffString1(document.getElementById('area1').value,this.value)"  rows="5" cols="72" name="user_text">
                </textarea>
          <br />  
      </form>
    </div>
</body>
</html>

