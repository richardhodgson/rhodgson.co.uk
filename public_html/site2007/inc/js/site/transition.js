/*
//Globals are very bad, but I think I should have one to set the transition speed.
var TransitionSpeed = 75;

$(document).ready(function () {
	
	//Add a big white screen over the page
	// (using an additional element as can't fade the <body> element)
	$('body').prepend('<div id="empty"></div>');
	
	
	//Position the screen div over the page
	$('#empty').css("height", GetHeight());
	$('#empty').css("width", GetWidth() + "px");
	
});


window.onload = function () {
	
	//Opera uses FastNavigation for its history, which basically stores the page state.
	// when going back, the page appears white as thats how we left it. OnUnload causes screen flickers.
	if (!window.opera) {
	
	//Window is loaded, present the page
	$('#empty').animate({opacity: 'hide'}, TransitionSpeed);
	
	//Attach transition behaviour to every Anchor, unless they have the class 'notransition'.
	$('a').not(".notransition").click(function () {
		
		//Catch the url we need to go to for the animation callback.
		var go = this;
		
		//The page has most likely moved since we saw the screen div, reposition it.		
		$('#empty').css("height", GetHeight());
		$('#empty').css("width", GetWidth() + "px");
		
		//Hide the page by showing the screen
		$('#empty').animate({opacity: 'show'}, TransitionSpeed, function() {
			
			//Direct browser to the page now the animation is complete.
			window.location = go;
		});
		
		//Clean up action, stop the Anchor executing as normally
		return false;
	});
	
	} else {
		
		//For Opera, only allow the fade in, which can take slightly longer too as there isn't a fade out.
		//$('#empty').animate({opacity: 'hide'}, 300);
		$('#empty').hide();
	}
	
}

window.onunload = function () {
	//alert('zxczxc');
	//
	
	if (!window.opera) {
		
		$('empty').hide();
	}
	//$('#empty').animate({opacity: 'hide'}, 300);
}


function GetHeight() {
	//IE doesn't seem to like clientHeight or outerHeight so this returns the proprietry value
	
	//If the browser doesn't have innerHeight property, cater for it (most likely IE)
	if (!window.innerHeight) {
		
		//Attach an empty marker to the end of smallBox or largeBox content
		$('#page div:first div:first').append('<div id="blob"></div>');
		
		//Get the height of the browser window
		var windowHeight = document.body.clientHeight;
		
		//Get the vertical position of div#blob. Add 267 to cater for the rest of the page below the marker.
		var anticipatedHeight = document.getElementById("blob").offsetTop + 267
		
		//Determine whether the page has been/can be scrolled down.
		if (anticipatedHeight > windowHeight) {
			
			//Page has been scrolled, extend screen div to cover properly.
			return anticipatedHeight + "px";
		} else {
			
			//Page hasn't been scrolled, it must be at the top so extend the screen to this height.
			return windowHeight + "px";
		}
		
		
	} else {
		
		//Ah, Gecko is much cleverer...
		//Return how far down the page we are plus the height of the window.
		return (window.pageYOffset + window.innerHeight) + "px";
	}
}


function GetWidth() {
	//return document.body.clientWidth;
	//As GetHeight() but with width...
	
	//Similiar detect to GetHeight();
	if (!window.innerWidth) {
		
		//IE's property that returns the browser window width.
		return document.body.clientWidth;
	} else {
		
		//Opera & Gecko's property that returns the same value as above.
		return window.innerWidth;
	}
}
*/