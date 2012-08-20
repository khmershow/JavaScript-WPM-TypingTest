function handler(options, success, response){
}

var api = findApiHost(window);

if(api != null){
	api.Terminate();
	api.Initialize();
}
else{
	alert("Error: unable to locate SCORM API");
}

 

function setScore(correctWPM) {
	scoreValue = api.GetValue('cmi.score.scaled');
	alert(correctWPM);
	var score = correctWPM;

	api.SetValue('cmi.completion_status','completed');
	api.SetValue('cmi.score.scaled',score);

	if(api != null){
		api.Commit();
		api.Terminate();
	}
}

function getCompletionState() {
	var scoreStatus = api.GetValue('cmi.completion_status');
	console.log(scoreStatus);
	return scoreStatus;//(scoreStatus.toLowerCase() == 'completed')?true:false;
}
 

function findApiHost(win) {
	// locate the API:
    if (win.goCourseApiHost != null){
        // try in this window
        return win.goCourseApiHost;
    }

    if (win.frames.length > 0){
        // try frameset kin
        for (var i=0; i<win.frames.length; i++){
			if (win.frames[i].goCourseApiHost != null){
				return win.frame[i].goCourseApiHost;
			}
		}
    }

    if (win.parent != win){
        // try parent
        return findApiHost(win.parent);
	}

	// else give up
    return null;
}