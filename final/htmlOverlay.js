// JavaScript Document
var typingTextArea;
var areaWidth = 0, areaHeight = 0, areaX = 0; areaY = 0;

function textCorrect(){
	adjustPosition();
	moveText();
}
function adjustPosition(){
	//typingTextArea = document.getElementById("userText");
	
	alert( document.getElementById('userText').width);
	//get the width
	areaWidth = document.getElementById('userText').width;
	areaHeight = document.getElementById('userText').height;
	
	//get the position
	
	areaX = document.getElementById('userText').offsetWidth;
	areaY = document.getElementById('userText').offsetHeight;
	
	//set overLay div to position and width
	
	//alert(areaWidth + "  " + areaHeight + "  " + areaX + "  " + areaY);
}
function moveText(){
	document.getElementById('textCorrection').width= areaWidth;
	document.getElementById('textCorrection').height= areaHeight;
	document.getElementById('textCorrection').offsetHeight= areaY;
	document.getElementById('textCorrection').offsetWidth= areaX;
}