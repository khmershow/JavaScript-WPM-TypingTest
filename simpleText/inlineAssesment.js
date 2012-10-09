$(document).ready(function(){
		var inlineElements = $("INLINE_ASSESSMENT");
		for(var i=0;i<inlineElements.length;i++) {
			//	These elements are intended to be defined within the inline assessment project... basically the users will specify the "type" and get this structure (among other things) which will allow them to simply use it, instead of re-making these every time.
			var inputElements = {'inputs': [$("<input type=\"submit\" id=\"vStart\" value=\"Start\" onClick=\"initializeAPI()\"/>")[0],$("<input type=\"submit\"  id=\"done\" value=\"Done\" onClick=\"doneClicked();\" />")[0],$("<br />")[0],$("<textarea id=\"userText\" rows=\"10\" cols=\"100\" name=\"user_text\" ></textarea>")[0]]};
			for(var j=0;j<inputElements.inputs.length;j++) {
				console.log(inputElements.inputs[j]);
				console.log(inlineElements[i]);
				inlineElements[i].appendChild(inputElements.inputs[j]);
		}
	}
});
