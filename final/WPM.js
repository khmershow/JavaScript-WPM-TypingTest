/*
start button functionality
all variables
*/
var finalText = "This is the final.";
var totalWords = null;
var wpm = null;
var totalError = null;
var cpm = null;
var accuracy = null;

function initText(){
	$("#area1").html(finalText);
	
}

function grader(){
	
}

function addTableData(){
	$("#totalWords").html(totalWords);
	$("#wpm").html(wpm);
	$("#totalError").html(totalError);
	$("#cpm").html(cpm);
	$("#accuracy").html(accuracy);
}