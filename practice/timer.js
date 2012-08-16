
var mins, secs, TimerRunning=false, TimerID, TheElement;

 
 function InitTimer() //call the Init function when u need to start the timer
 {
    mins=5;
    secs=0;
    StopTimer();
    StartTimer();
 }
function StopTimer()
 {	 
    if(TimerRunning)
       clearInterval(TimerID);
    TimerRunning=false;
	
 }
function loopTimer() {
	
	TheElement = document.getElementById("txt");
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
	
	TimerID = window.setInterval("loopTimer()",1000);
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
