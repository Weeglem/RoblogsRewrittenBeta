function ShareLink() {
	
    let textData = window.location; //burn in hell IE

	if (window.clipboardData) { // this is for Internet Explorer
		window.clipboardData.setData("Text", textData);
	}
	else { // this is for Edge, Firefox, Chrome and Safari; this also works with IE, but it does not work as smoothly as above code causing the page to jump around
		var t = document.createElement("textarea"); // create textarea element
		t.value = textData; // set its value to the data to copy
		t.style.position = "absolute";
		t.style.display = "inline";
		t.style.width = t.style.height = t.style.padding = 0;
		t.setAttribute("readonly", ""); // textarea is readonly
		document.body.appendChild(t); // append the textarea element - may be better to append to the object being clicked
		t.select(); // select the data in the text area
		document.execCommand("copy"); // IMPORTANT: "copy" works as a result of user events, like "click" event
		document.body.removeChild(t); // remove the textarea element
	}
	alert("Link has been copied to the clipboard.");
	return false;
}