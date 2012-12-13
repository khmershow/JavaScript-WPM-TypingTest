$(document).ready(function(){
	switch(INLINE_ASSESMENT) {
	case "simple_text":
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
		break;
		case "typing_test":
			var inlineElements = $("INLINE_ASSESSMENT");
			for(var i=0;i<inlineElements.length;i++) {
			//	These elements are intended to be defined within the inline assessment project... basically the users will specify the "type" and get this structure (among other things) which will allow them to simply use it, instead of re-making these every time.
				var fileref=document.createElement('script');
					fileref.setAttribute("type","text/javascript");
					fileref.setAttribute("src",timer.js );
				var fileref2=document.createElement('script');
					fileref2.setAttribute("type","text/javascript");
					fileref2.setAttribute("src",checker.js );
				var fileref3=document.createElement('script');
					fileref3.setAttribute("type","text/javascript");
					fileref3.setAttribute("src",copyPaste.js );
				var inputElements = {'inputs': [$("Time remaining:<input id=\"txt\" readonly type=\"text\" value=\"\" border=\"0\" name=\"disp\">")[0],$("<br />")[0],$("<div id=\"inputText\" style=\"position:static; width:823px; height:166px;\">")[0],$("<textarea id=\"area1\"  onkeydown=\"return disableCtrlKeyCombination(event);\" onKeyUp=\"return disableCtrlKeyCombination(event);\"  style=\"font-family:Arial, Helvetica, sans-serif;\" readonly rows=\"10\" cols=\"133\"></textarea>")[0],$("<div id=\"textCorrection\" style=\"position:relative ; z-index:999; top:-175px;left:0px; width:inherit; height:inherit; background:white; overflow:auto; border:thin; border-style:solid; border-color:#B4B4B4;\">Type the text that appears here in the box below. Click Start to begin.</div>")[0],$("</div>")[0],$("<br />")[0],$("<input class=\"in\" type=\"submit\" action=\"vstart\" id=\"vStart\" value=\"Start Test\" onClick=\"startClicked();\" />")[0],$("<input type=\"submit\" name=\"done\" id=\"done\" value=\"Done\" onClick=\"doneClicked();\" />")[0],$("<br />")[0],$("<textarea id=\"userText\" onKeyDown=\"return disableCtrlKeyCombination(event);\" onKeyUp=\"diffString1(document.getElementById('area1').value,this.value);\" rows=\"10\" cols=\"100\" name=\"user_text\" ></textarea>")[0],$("<br />")[0],$("<div id=\"scoreTable\" ></div>")[0]]};
			for(var j=0;j<inputElements.inputs.length;j++) {
				console.log(inputElements.inputs[j]);
				console.log(inlineElements[i]);
				inlineElements[i].appendChild(inputElements.inputs[j]);
			}
		break;
	}
}