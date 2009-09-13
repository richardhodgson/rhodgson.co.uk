/**
 * @author Richard Hodgson
 */

//Empty var, used to set the next page to redirect to after transitions
var nextPage = '';

window.onload = function () {
	
	//Replace a href links to utilise transitions
	replaceAnchors();
	
	//All loaded, show the page
	Effect.Fade($('empty'), {duration: '0.4', delay: 0.1});
	
	test();
}

function gotoPage() {
	
	//Use the variable set by go()
	window.location = nextPage;
}

function go(page) {
	
	//Fade out the current page
	Effect.Appear($('empty'), {duration: '0.4', delay: 0});
	
	//Set the next page to go to
	nextPage = page;
	
	//Wait for the animation to complete, then redirect to the new page
	setTimeout(gotoPage, 400);
}

function replaceAnchors() {
	
	var el = document.getElementsByTagName('A');
	
	for(i= 0; i < el.length; i++) {
		
		page = el[i];
		
		el[i].href = 'javascript: go(\'' + page + '\')';
		
		// Onclick action looses page reference.
		//el[i].href = '#';
		//Event.observe(el[i], 'click', function () { go(page) }, false);
	}
	
	
}

function test() {
	
	//alert('test');
	alert(Document.cookie);	
}

