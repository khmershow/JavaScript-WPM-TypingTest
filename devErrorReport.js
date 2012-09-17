// JavaScript Document
//var isDev = (window.location.hostname.test('/dev|test|localhost)/i'))?true:false;

window.onerror = windowOnError;

function windowOnError(message, url, lineNumber){
	
	alert("error on page, refer to console");
	
	console.log("Error exists on page at:");
	console.log("URL: " + url);
	console.log("Line Number: " + lineNumber);
	console.log("Message: " + message);
		
}