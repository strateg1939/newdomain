/*var ourRequest = new XMLHttpRequest();
ourRequest.open('GET', 'http://localhost:8888/wordpress/wp-json/wp/v2/posts');
ourRequest.onload = function() {
  if (ourRequest.status >= 200 && ourRequest.status < 400) {
    var data = JSON.parse(ourRequest.responseText);
  } else {
    console.log("We connected to the server, but it returned an error.");
  }
};

ourRequest.onerror = function() {
  console.log("Connection error");
};

ourRequest.send();*/
var subs_submit =  document.getElementById("subs_submit");
if(subs_submit){
	subs_submit.addEventListener("click", function(){
		console.log("success");
	})
} 
