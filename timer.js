var mins,secs,TimerRunning=false,TimerID,TheElement,stopTime,startTime,secDiff;
var secCount = 0;

 
 function InitTimer() //call the Init function when u need to start the timer
 {
    mins=5;
    secs=0;
   // StopTimer();
    StartTimer();
	//alert("InitTimer started");
 }
function StopTimer()
 {	 
    if(TimerRunning)
       clearInterval(TimerID);
    TimerRunning=false;
	stopTime=Math.round(+new Date()/1000);
	
	//alert("stop time" + stopTime);
	//alert("stoptime:"+ typeof stopTime);
	secCount= secCount*1;
	//alert(typeof secCount + "   " + secCount);
 }
function loopTimer() {

	secCount++;
	
    TheElement.value = Pad(mins)+":"+Pad(secs);
    Check();
    
    if(mins<=0 && secs<=0)
       StopTimer();
	       
    if(secs==0)
    {
       mins--;
       secs=60;
    }
	
    secs--;
 }

 function StartTimer()
 {
    TimerRunning=true;
	startTime = Math.round(+new Date()/1000);
	TheElement = document.getElementById("txt");
	TimerID = window.setInterval("loopTimer();",1000);
	//alert("start time" + startTime);
	//alert("starttime:"+ typeof startTime);
 }
function Check()
 {
     if(mins==0 && secs==0)
    {
     	clearInterval(TimerID);
	 	var doneButton = document.getElementById("done");
	 	doneButton.click();
    }
 }
function Pad(number) //pads the mins/secs with a 0 if its less than 10
 {
    if(number<10)
       number=0 + "" + number;
    return number;
 }

function onLoadFunc(){

	var startB = document.getElementById("vStart");
	var stopB = document.getElementById("done");
	
	startB.addEventListener('click', InitTimer , false)
	stopB.addEventListener('click', StopTimer , false)
		
}
