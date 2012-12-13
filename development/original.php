<?PHP
function _Cmp($a,$b){
$line1=explode("|",$a);
$line2=explode("|",$b);
if ($line1[5] ==$line2[5])
return 0;
return ($line1[5] >$line2[5]) ? -1 : 1;
}
function FillTable($A){?>
<table class="ta ac"><tr><th class="th" style="width: 30%">Name</th><th class="th" style="width: 20%">Date, Time</th><th class="th" style="width: 15%">Duration (s)</th><th class="th" style="width: 17%">Accuracy (%)</th><th class="th" style="width: 10%">WPM</th><th class="th" style="width: 10%">CPM</th></tr>
<?PHP
for($i=0;$i<count($A);$i++){
$line=explode("|",$A[$i ]);
echo "<tr>";
for($j=0;$j<6;$j++){
if($j)
echo "<td class=\"td\">";
else
echo "<td class=\"td al\">";
if(isset($line[$j]))
echo $line[$j];
echo "</td>";
}
echo "</tr>";
}
echo "</table>";
}
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
function AddNewRow ($path,$name,$data,$time,$wpm,$cpm,$error){
$content=file_get_contents($path);
$content=substr($content,0,strrpos($content,'`'));
file_put_contents($path,"$name|$data|$time|$error|$wpm|$cpm|`\r\n".$content);
}
function AddTypist ($chapter,$name,$data,$time,$wpm,$cpm,$error){
if($name == "")return;
$name=substr($name,0,25);
if(strpbrk($name,"<"))return;
$min_time = 24; 
if($chapter == 1){
 $min_time = 28;
} else
if($chapter == 2){
 $min_time = 32;
} else
if($chapter == 3){
 $min_time = 36;
}
if(($time<$min_time))return;
AddNewRow($_SERVER['DOCUMENT_ROOT']."/typingtest/last_typist.txt",$name,$data,$time,$wpm,$cpm,$error);
if($error != 100)return;
$CT=file($_SERVER['DOCUMENT_ROOT']."/typingtest/champions_typist.txt");
$sz=count($CT);
if($sz == 10){
$line=explode("|",$CT[ 9 ]);
if($cpm >=$line[5]){
$CT[ 9 ]="$name|$data|$time|$error|$wpm|$cpm|\r\n";
}
} else {
$CT[ $sz ]="$name|$data|$time|$error|$wpm|$cpm|\r\n";
}

usort($CT,"_Cmp");

$full_line="";
for($i=0;$i<count($CT);$i++){
 $full_line .=$CT[$i ];
}
file_put_contents($_SERVER['DOCUMENT_ROOT']."/typingtest/champions_typist.txt",$full_line);
}

function SaveLog($type){
$path=$_SERVER['DOCUMENT_ROOT']."/typingtest/log.ini";
$LOG=parse_ini_file($path);
$change=$LOG[ "BUT_CHANGE" ];
if($type == 0)
$change++;
$start=$LOG[ "BUT_START" ];
if($type == 1)
$start++;
$end=$LOG[ "BUT_END" ];
if($type == 2)
$end++;
$fp=fopen($path,"w");
if(flock($fp,LOCK_EX)) { // do an exclusive lock
fwrite($fp,"BUT_CHANGE=".$change."\n");
fwrite($fp,"BUT_START=".$start."\n");
fwrite($fp,"BUT_END=".$end."\n");
flock($fp,LOCK_UN);
}
fclose($fp);
}

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
$les_text=file_get_contents( $_SERVER['DOCUMENT_ROOT']."/typingtext/".$num_type."/".$num.".txt" );
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
SaveLog(0);
$num_type=$_POST["numtype"];
$num=$_POST["num"];
}
if(isset($_POST["start"])){
SaveLog(1);
$time_start=microtime(true);
$readonly="";
$welcome="";
$style_text="id=\"area3\"";
$was_start=1;
}

$les_text=file_get_contents( $_SERVER['DOCUMENT_ROOT']."/typingtext/".$num_type."/".$num.".txt" );

if(isset($_POST["done"])){
SaveLog(2);
$user_text=str_replace("\r\n","",$_POST["user_text"]); 
$user_text=str_replace("\n","",$user_text);
$total_time=microtime(true)-$time_start-1;

$char=strlen($les_text);
$word=substr_count($les_text,' ') + 1;
$word += substr_count($les_text,'.');
$word += substr_count($les_text,',');
$word += substr_count($les_text,';');
$wpm=round($word/$total_time * 60);
$cpm=round($char/$total_time * 60);
$accuracy=100-round(GetError($les_text,$user_text) * 100 /$char);
if($was_start)
 $Ret=AddTypist($num_type,$name,date("d M,").date("H:i"),round($total_time),$wpm,$cpm,$accuracy);
$time_start=0;
$readonly='readonly="readonly"';
$was_start=0;
}

?>
<hr />
<div class="ac"><?php echo $total_time; ?>
	<form method='post' action="original.php">
    	Your Name: <input class="in" style="width:200px" type="text" name="name" value="<?PHP echo $name?>" />
        max. 25 chars)
        <br /> <br /> 
        Select text: <select class="in" name="numtype" style="width:160px">
        	<option value="0" 
            	<?if($num_type==0){?>
                	selected="selected"<?}?>>
                	100-200 chars
             </option>
             <option value="1" 
             	<?if($num_type==1){?>
                selected="selected"<?}?>>
                200-300 chars
             </option> 
             <option value="2" 
             	<?if($num_type==2){?>
                selected="selected"<?}?>>
                300-400 chars
             </option>
             <option value="3"
             	<?if($num_type==3){?>
             	selected="selected"<?}?>>
                400-500 chars
             </option>
             </select> 
             # <select name="num" style="width:35px"> 
             <option value="0" 
             	<?if($num==0){?>
                selected="selected"<?}?>>
                1
             </option>
             <option value="1" 
             	<?if($num==1){?>
                selected="selected"<?}?>>
                2
             </option> 
             <option value="2" 
             	<?if($num==2){?>
                selected="selected"<?}?>>
                3
             </option>
             <option value="3" 
             	<?if($num==3){?>
                selected="selected"<?}?>>
                4
             </option>
             <option value="4"
                  <?if($num==4){?>
                  selected="selected"<?}?>>
                  5
             </option>
             <option value="5" 
                  <?if($num==5){?>
                  selected="selected"<?}?>>
                  6
             </option> 
             <option value="6" 
                  <?if($num==6){?>
                  selected="selected"<?}?>>
                  7
             </option> 
             <option value="7" 
                  <?if($num==7){?>
                  selected="selected"<?}?>>
                  8
             </option> 
             <option value="8" 
                  <?if($num==8){?>
                  selected="selected"<?}?>>
                  9
              </option>
              </select> 
              <input type="submit" name="update" value="Update Text" /> 
              <br />
              <br />
              <?if(isset($_POST["done"])){?> 
			  		<?php echo $total_time?>
              		<input class="in" type="submit" name="start" value="To Repeat Test" />
                    <br />
                    <table class="ta" cellspacing="0" cellpadding="6">
                    	<tr>
                    		<th class="th" style="width: 50%">Parameter
                            </th>
                            <th class="th" style="width: 50%">Your result
                            </th>
                        </tr>
                        <tr> 
                        	<td class="td"><b>WPM</b> (word per minutes)
                            </td>
                            <td class="td"><b><?PHP echo $wpm?></b>
                            </td>
                        </tr>
                        <tr> 
                        	<td class="td"><b>CPM</b> (char per minutes)
                            </td> 
                            <td class="td"><b><?PHP echo $cpm?></b>
                            </td>
                        </tr>
                        <tr> 
                        	<td class="td"><b>Accuracy</b> (%)
                            </td>
                            <td class="td"><b><?PHP echo $accuracy?></b>
                            </td>
                        </tr>
                   </table>
		<?}else{?>
			<textarea id="area1" onselectstart="return false" onpaste="return false" style="-moz-user-select: none;-khtml-user-select: none; user-select: none;" readonly="readonly" rows="5" cols="72"><?PHP echo $les_text?></textarea>
			<br />
			<input class="in" type="submit" name="start" value="Start Test" />
			<br />
			<textarea <?PHP echo $style_text.$readonly?> rows="5" cols="72" name="user_text"><?PHP echo $welcome?></textarea>
    		<br /> 
    		<input type="submit" name="done" value="Done" />
    	<?}?>
     		<input type="hidden" name="was_start" value="<?PHP echo $was_start?>" />
      		<input type="hidden" name="vnum" value="<?PHP echo $num?>" />
       		<input type="hidden" name="vnumtype" value="<?PHP echo $num_type?>" />
        	<input type="hidden" name="vstart" value="<?PHP echo $time_start?>" />
        </form>
    </div>
<?PHP
$LT=file($_SERVER['DOCUMENT_ROOT']."/typingtest/last_typist.txt");
echo"<hr /><h3>Latest</h3>";
FillTable($LT);
$CT=file($_SERVER['DOCUMENT_ROOT']."/typingtest/champions_typist.txt");
echo"<hr /><h3>Champions</h3>";
FillTable($CT);
  ?>