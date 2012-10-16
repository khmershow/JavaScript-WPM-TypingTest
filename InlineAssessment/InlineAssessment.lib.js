var inlineAssessmentIdCounter = 0;
function InlineAssessment(elementArg) {
	//	static for class
	this.allTypes = {
		'wpm_test': {
			'inputElementsString': "Time remaining:<input id=\"txt\" readonly type=\"text\" value=\"\" border=\"0\" name=\"disp\">\n" +
				"	<br />\n" +
				"	<div id=\"inputText\" style=\"position:static; width:823px; height:166px;\">\n" +
				"	<textarea id=\"area1\"  onkeydown=\"return disableCtrlKeyCombination(event);\" onKeyUp=\"return disableCtrlKeyCombination(event);\"  style=\"font-family:Arial, Helvetica, sans-serif;\" readonly rows=\"10\" cols=\"133\"></textarea>"	+
				"    	<div id=\"textCorrection\" style=\"position:relative ; z-index:999; top:-175px;left:0px; width:inherit; height:inherit; background:white; overflow:auto; border:thin; border-style:solid; border-color:#B4B4B4;\">Type the text that appears here in the box below. Click Start to begin.	" +
				"		</div>" +
				"    </div>" +
				"   <br /> " + 
				"   <input class=\"in\" type=\"submit\" action=\"vstart\" id=\"vStart\" value=\"Start Test\" onClick=\"startClicked();\"  />" +
				"	<input type=\"submit\" name=\"done\" id=\"done\" value=\"Done\" onClick=\"doneClicked();\" />" +
				"    <br /> " + 
				"   <textarea id=\"userText\" onKeyDown=\"return disableCtrlKeyCombination(event); \" onKeyUp=\"diffString1(document.getElementById('area1').value,this.value);\" rows=\"10\" cols=\"100\" name=\"user_text\" ></textarea>" + 
				"   <br />  " +
				"   <div id=\"scoreTable\" >" +             
				" 	</div>",
			'methods': [
				{
						'name': "startClick",
						'type': "click",
						'id': "",
						'handler': function() {
						}
				}
			]
		},
		'simple_text': {
				'inputElementsString':"<input/><input type=\"button\" value=\"submit thingie\"/>"
		},
		'simple_menu': {
				'inputElementString':"<select>" + 
					"	<option  value=\"100\">100%</ option>" +
					"	<option  value=\"90\">90%</ option>" +
					"	<option  value=\"80\">80%</ option>" +
					"	<option  value=\"70\">70%</ option>" +
					"	<option  value=\"60\">60%</ option>" +
					"	<option  value=\"50\">50%</ option>" +
					"	<option  value=\"10\">10%</ option>" +
					"</select>" +
					"<input type=\"submit\" value=\"Submit\" onClick=\"setScore(value)\">"	
		}
	};
	
	this.type;
	this.id = inlineAssessmentIdCounter++;
	
	this.setElement = function( elementArg ) {
		this.emptyElement();
		if(!this.isElement(elementArg)) {
			console.log(typeof elementArg);
			throw 'Error (Inline Assessment): element must be a valid dom element.'; 
		}
		this.element = elementArg;
		this.setType( this.element );
		this.display( this.element );
		if (this.allTypes[this.type].methods > 0){
			this.setEvents();
		}
		return this.element;
	};
	
	this.isElement = function(obj) {
		try {
			//Using W3 DOM2 (works for FF, Opera and Chrom)
			return obj instanceof HTMLElement;
		}
		catch(e){
			//Browsers not supporting W3 DOM2 don't have HTMLElement and
			//an exception is thrown and we end up here. Testing some
			//properties that all elements have. (works on IE7)
			return (typeof obj==="object") &&
				(obj.nodeType===1) && (typeof obj.style === "object") &&
				(typeof obj.ownerDocument ==="object");
		}
	}
	
	this.setType = function() {
		if(!this.element) {
			throw "Error (Inline Assessment): You can't set the type before there is an element defined.";
			return false;
		} else {
			this.type = this.element.getAttribute("type");
		}
		
		var inputElementString = (this.allTypes[this.type]) ? this.allTypes[this.type].inputElementsString : "<span>Inline assessment input element type not found (" + this.type + "). Please define them before using this tool.</span>";
		for(var i=0;i<this.allTypes[this.type].methods.length;i++) {
			switch(this.allTypes[this.type].methods[i].type) {
				case "change":
					$(this.allTypes[this.type].methods[i].id).change(this.allTypes[this.type].methods[i].handler);
				break;
				default:
					$(this.allTypes[this.type].methods[i].id).click(this.allTypes[this.type].methods[i].handler);
				break;
			}
		}
		var DOMNodesCreate = $("<div>"+inputElementString+"</div>");
		this.DOMNodes = DOMNodesCreate;
		return this.type;
	}
	
	this.emptyElement = function() {
		if(this.element) {
			var loopLimit = 1000;
			var loopCount = 0;
			if(this.element.children != undefined) {
				while(this.element.children.length > 0 && loopCount < loopLimit) {
					this.element.removeChild(this.element.children[0]);
					loopCount++;
				}
			} else
				throw "Error (Inline Assessment): element.children undefined. element must be invlid DOM (for instance: it could be a text node instead of an element node)";
		}
		return true;
	};
	
	this.display = function() {
		this.emptyElement();
		if( this.DOMNodes ) {
			for(var i=0; i < this.DOMNodes.length; i++)
				this.element.appendChild( this.DOMNodes[i] );
		} else {
			throw "Error (Inline Assessment): the intended DOM elements are invalid.";
			return false;
		}
		return this.element;
	};
	
	this.setEvents = function(){
		
		
	}
	
	this.setElement( elementArg );

	if(!this.element) {
		if(!this.setElement( elementArg )) {
			if(!this.element || this.element === undefined) {
				throw "Error (Inline Assessment): element not specified.";
				return false;
			}
			//throw "Error (Inline Assessment): failed creating element input.";
			//return false;
		}
	}
	console.log(this);
	return this;
}
InlineAssessment.prototype.getId = function() { return this.id; };
InlineAssessment.prototype.getType = function() { return this.type; };
InlineAssessment.prototype.getElement = function() { return this.element; };

var assessmentElements;
$(document).ready(function(){
	assessmentElements = $("INLINE_ASSESSMENT");
	for(var a=0; a < assessmentElements.length; a++) {
		assessmentElements[a] = new InlineAssessment(assessmentElements[a]);
	}
});