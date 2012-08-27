// JavaScript Document
var numberOfCInWord = 5;


var canvas, ctx;
var window_Height, window_Width;

var imageCount = 0;

var startButton;

var  startFinishImg, roadImg, playerCarImg, opponentCarImg;

var startFinishImgPath = "Images/startFinish.png";
var roadImgPath = "Images/road.png";
var playerCarPath = "Images/car1.png";
var oppenentCarPath = "Images/car2.png";

var roadImgRatio, carImgRatio;

var roadTimer, carTimer;

var startingLine = true;
var roadOffset = .5;

var playerRand = 0, opponentRand = 0;
var switchRand = true, moveStart = true, finishLine = false, enterFinish1 = false, enterFinish2 = false;
var carOffset = oppOffset = .08;
var destination;

var tInput, eInput, aInput, WPM;
var WPMCount, tCount, eCount, aCount;

/******testing******/
var finishEl;
var fadeCanvas = false, alpha = 1;
var textArea = "", cCount = 0, elapsedTime = 0, timeInterval;

function initGame () {

	startFinishImg = new Image();
	eventRegistrar(startFinishImg,'load',onImage);
	startFinishImg.src = startFinishImgPath;

	roadImg = new Image();
	eventRegistrar(roadImg, 'load',onImage,false);
	roadImg.src = roadImgPath;

	playerCarImg = new Image();
	eventRegistrar(playerCarImg, 'load',onImage);
	playerCarImg.src = playerCarPath;

	opponentCarImg = new Image();
	opponentCarImg.src = oppenentCarPath;
	eventRegistrar(opponentCarImg, 'load',onImage);

}

/********************************
*
*onImage allows all for images to load before proceeding
*
*if the number of images increase, the number in the if(imageCount == *number*) needs to be increased
********************************/
function onImage () {	
	imageCount++;
	if(imageCount == 4)
		setup();
}

/********************************
*
*This function "setup" is the first of the functions needed to setup the canvas
*
*gets window size, retrieves elements into javascrip variables and sets event for changin WPM
*
*calls setCanvas() and initDrawing() at the end
********************************/
function setup () {
	var size;

	size = get_window_size();

	window_Height = size[0];
	window_Width = size[1];

	roadImgRatio = roadImg.height/roadImg.width;
	carImgRatio = playerCarImg.width/playerCarImg.height;

	tInput = document.getElementById("terribleWPM");
	tCount = 1 * tInput.value;

	eInput = document.getElementById("expectedWPM");
	eCount = 1 * eInput.value;

	aInput = document.getElementById("awesomeWPM");
	aCount = 1 * aInput.value;

	WPM = document.getElementById("testWPM");
	WPMCount = 1 * WPM.value;

	finishEl = document.getElementById("fButton");
	eventRegistrar(finishEl, 'click', setFinish);	

	startButton = document.getElementById("vStart");
	eventRegistrar(startButton, 'click', startRace);	

	setCanvas();
	initDrawing();
}

function setFinish(e){
	finishLine = !finishLine;
}


/*************************************
*
*attached via a listener to WPM. Whenever the WPM changes, the javascript value is updated
*
*************************************/
function setWPMVariable() {
	elapsedTime += .1;
	cCount = textArea.value.length;
	WPMCount = (cCount/numberOfCInWord)/ (elapsedTime/60);
	WPM.value = WPMCount;	
}

/*************************************
*
*returns object to which the event (e) just triggered on
*
*************************************/
function getTarget(e){

	var targetElement;
	if (!e) var e = window.event;
	if (e.target) targetElement = e.target;
	else if (e.srcElement) targetElement = e.srcElement;
	if (targetElement.nodeType == 3) // defeat Safari bug
		targetElement = targetElement.parentNode;
	return targetElement;
}

/*************************************
*
*universal event registration, cross compatible
*
*************************************/
function eventRegistrar(element, eventType, handlerFunction) {
	if(element.addEventListener) {
		element.addEventListener(eventType,handlerFunction,false);
	} else {
		element.attachEvent('on'+eventType,handlerFunction);
	}
}

/*************************************
*
*retrieves canvas element and context and sets hieght and width
*
*************************************/
function setCanvas () { 
	var typingDivHeight;

	//typingDivHeight = document.getElementById("typingDiv").offsetHeight;

	canvas = document.getElementById("canvas");
	ctx = canvas.getContext('2d');

	if(window_Width > 1000)
		canvas.width = 1000;
	else
		canvas.width = window_Width*.95;

	canvas.height = canvas.width * roadImgRatio;
}

/*************************************
*
*sets initial drawing, simple still image
*
*************************************/
function initDrawing () {
	ctx.drawImage(startFinishImg, 0, 0, canvas.width, canvas.height);
	ctx.drawImage(opponentCarImg, 0, canvas.height * .25, canvas.height * .5 * carImgRatio, canvas.height*.5);
	ctx.drawImage(playerCarImg, 0, canvas.height * .35, canvas.height * .5 * carImgRatio, canvas.height*.5);
}

/*************************************
*
*disables start button and starts intervals
*
*************************************/
function startRace () {

	textArea = document.getElementById("userText");
	textArea.value = "";
	cCount = textArea.value.length;
	
	startButton.setAttribute('disabled','disabled');

	timeInterval = setInterval("setWPMVariable()",100);
	roadTimer = setInterval("moveRoad()", 16);
	carTimer = setInterval("moveCar()", 16);
}


/*************************************
*
*
*handles the movement of the road
*starts with start line and then moves to the generic road
*
*
*************************************/
function moveRoad () {
	var roadWidthRatio = startFinishImg.width/canvas.width;

	ctx.clearRect(0, 0, canvas.width, canvas.height);

	if(roadOffset < canvas.width){
		if(startingLine)
			roadOffset *= 1.02;
		else			
			roadOffset += 20;
	}else{ 
		roadOffset = 0;
		startingLine = false;
		if(finishLine)
			enterFinish1 =true;
	}


	if(startingLine){
		ctx.drawImage(startFinishImg, roadOffset * roadWidthRatio, 0, startFinishImg.width - roadOffset*roadWidthRatio, startFinishImg.height, 0, 0, canvas.width - roadOffset, canvas.height);
		ctx.drawImage(roadImg, 0, 0, roadOffset * roadWidthRatio, startFinishImg.height, canvas.width - roadOffset, 0, roadOffset, canvas.height);
	}else if(enterFinish1){

		ctx.drawImage(roadImg, roadOffset * roadWidthRatio, 0, startFinishImg.width - roadOffset*roadWidthRatio, startFinishImg.height, 0, 0, canvas.width - roadOffset, canvas.height);
		ctx.drawImage(startFinishImg, 0, 0, roadOffset * roadWidthRatio, startFinishImg.height, canvas.width - roadOffset, 0, roadOffset, canvas.height);
		if(roadOffset  >= canvas.width){
			enterFinish1 = false;
			finishLine = false;
			enterFinish2 = true;
		}
	}else if(enterFinish2){
		ctx.drawImage(startFinishImg, roadOffset * roadWidthRatio, 0, startFinishImg.width - roadOffset*roadWidthRatio, startFinishImg.height, 0, 0, canvas.width - roadOffset, canvas.height);
		ctx.drawImage(roadImg, 0, 0, roadOffset * roadWidthRatio, startFinishImg.height, canvas.width - roadOffset, 0, roadOffset, canvas.height);
		if(roadOffset  >= canvas.width){
			enterFinish2 = false;
			WPM.removeEventListener('change',setWPMVariable,false);
			fadeCanvas = true;
		}
	}else{
		if(fadeCanvas){
			alpha -= .005;
			if(alpha < .001){
				endOfGame();
				return;
			}
			ctx.globalAlpha = alpha;
		}
		ctx.drawImage(roadImg, roadOffset * roadWidthRatio, 0, roadImg.width - roadOffset*roadWidthRatio, roadImg.height, 0, 0, canvas.width - roadOffset, canvas.height);
		ctx.drawImage(roadImg, 0, 0, roadOffset * roadWidthRatio, startFinishImg.height, canvas.width - roadOffset, 0, roadOffset, canvas.height);
	}
}

function endOfGame() {
	clearInterval(roadTimer);
	clearInterval(carTimer);

	ctx.clearRect(0, 0, canvas.width, canvas.height);
	ctx.globalAlpha = 1;
	ctx.font        = "normal 36px Arial";
	ctx.strokeStyle = "#000000";
	ctx.strokeText("Congratulations!!!!", 50, 90);
}

/*************************************
*
*
*handles the movement of the vehicles, both forward and backwards as well as up and down (creates "rumble" of engines)
*
*
*************************************/
function moveCar () {
	
	var roadWidthRatio = playerCarImg.width/canvas.width;
	var playerPosition = carOffset;
	var opponentPosition = oppOffset;
	
	/*****this is what does the up and down creating the "rumble" *****/
	if(!switchRand){
		playerRand = -Math.floor(Math.random()+1);
		opponentRand = Math.floor(Math.random()+1);
		switchRand = true;
	}else{
		playerRand *= -1;
		opponentRand *= -1;
		switchRand = false;
	}

	/*****stops the cars at half the canvas*****/
	if(carOffset >(canvas.width*.5 - (canvas.height *.25 * carImgRatio))){
		moveStart= false;
	}

	if(moveStart){

		/*****creates acceleration*****/

		oppOffset = carOffset *= 1.015;
	}else{

		/*****movement backward and forward based on updated WPMCount*****/

		if(WPMCount >= tCount && WPMCount <= aCount)
			destination = canvas.width - ((WPMCount-tCount)/(aCount-tCount))*canvas.width - (canvas.height *.25 * carImgRatio);
		else if(WPMCount < tCount)
			destination = canvas.width - (canvas.height *.25 * carImgRatio);
		else if (WPMCount > aCount)
			destination = (-1*(canvas.height *.25 * carImgRatio));

		if(destination > oppOffset)
			oppOffset++;
		else if(destination < oppOffset)
			oppOffset--;
	}
	
	ctx.drawImage(opponentCarImg, oppOffset, canvas.height * .25 + opponentRand, canvas.height * .5 * carImgRatio, canvas.height*.5);
	ctx.drawImage(playerCarImg, carOffset, canvas.height * .35 + playerRand, canvas.height * .5 * carImgRatio, canvas.height*.5);
	

}

/***** 
*
* gets windows size, works with all browsers
*
*****/
function get_window_size () {
	var winW = 630, winH = 460;
	if (document.body && document.body.offsetWidth) {
		winW = document.body.offsetWidth;
		winH = document.body.offsetHeight;
	}
	if (document.compatMode=='CSS1Compat' &&
		document.documentElement &&
		document.documentElement.offsetWidth ) {
		winW = document.documentElement.offsetWidth;
		winH = document.documentElement.offsetHeight;
	}
	if (window.innerWidth && window.innerHeight) {
		winW = window.innerWidth;
		winH = window.innerHeight;
	} 	
	return [ winH, winW];
}