function subs_send_data(){
	var all_subscriptions =  document.getElementById("subscription_for_user").querySelectorAll(".option-input");
	var topic;
	var topic_id;
	var send_data = {to_subscribe : [], to_unsubscribe : [],to_subscribe_id: [], to_unsubscribe_id : [], user_mail : params.mail};
	for(let i = 0; i < all_subscriptions.length; i++){
		if(all_subscriptions[i].checked){
			send_data.to_subscribe.push(all_subscriptions[i].value);
			send_data.to_subscribe_id.push(all_subscriptions[i].name);
		}
	}
	var all_unsubscriptions =  document.getElementById("unsubscription_for_user").querySelectorAll(".option-input");
	for(let i = 0; i < all_unsubscriptions.length; i++){
		if(all_unsubscriptions[i].checked){
			send_data.to_unsubscribe.push(all_unsubscriptions[i].value);
			send_data.to_unsubscribe_id.push(all_unsubscriptions[i].name);
		}
	}
	if(send_data.to_subscribe.length === 0 && send_data.to_unsubscribe.length === 0){
		document.getElementById("response_text").style.display = "none";
		document.getElementById("response_text_hr").style.display = "none";
		return;
	}
	var ourRequest = new XMLHttpRequest();
	ourRequest.open('POST', 'http://newdomain/wp-json/sendsubs/v1/user/' + params.id);


	ourRequest.onreadystatechange = function() {
		if (ourRequest.status >= 200 && ourRequest.status < 400 && ourRequest.readyState === 4) {
			if(ourRequest.responseText !== "success"){
				alert("Server error, try again later");
				return;
			}

			document.getElementById("response_text").style.display = "inline";
			document.getElementById("response_text_hr").style.display = "block";
			for(let i = 0; i < send_data.to_subscribe.length; i++){
				topic = send_data.to_subscribe[i];
				topic_id = send_data.to_subscribe_id[i];
				document.getElementById(topic).remove();
				document.getElementById(topic + ".text").remove();
				document.getElementById("unsubscription_for_user").innerHTML += "<p><input type='checkbox' id = \'" + topic + "\'  class = 'option-input' value =  \'" + topic + "\' name = \'" + topic_id + "\' ><span class = 'checkbox_text' id = \'" + topic + ".text\' > " + topic + " </span></p>";

			}    
			for(let i = 0; i < send_data.to_unsubscribe.length; i++){
				topic = send_data.to_unsubscribe[i];
				topic_id = send_data.to_unsubscribe_id[i];
				document.getElementById(topic).remove();
				document.getElementById(topic + ".text").remove();
				document.getElementById("subscription_for_user").innerHTML += "<p><input type='checkbox' id = \'" + topic + "\'  class = 'option-input' value = \'" + topic + "\'  name = \'" + topic_id + "\'><span class = 'checkbox_text' id = \'" + topic + ".text\' > " + topic + " </span></p>";
			}
			if(document.getElementById("another_text_sub").style.display === "none" &&  document.getElementById("subscription_for_user").querySelectorAll(".option-input").length > 0){
				document.getElementById("another_text_sub").style.display = "inline";
			}
			else if((document.getElementById("another_text_sub").style.display === "inline"|| document.getElementById("another_text_sub").style.display === "") &&  document.getElementById("subscription_for_user").querySelectorAll(".option-input").length === 0){
				document.getElementById("another_text_sub").style.display = "none";
				document.getElementById("hr").style.display = "none";
			}

			if(document.getElementById("another_text_unsub").style.display === "none" && document.getElementById("unsubscription_for_user").querySelectorAll(".option-input").length > 0){
				document.getElementById("another_text_unsub").style.display = "inline";
			}
			else if((document.getElementById("another_text_unsub").style.display === "inline" || document.getElementById("another_text_unsub").style.display === "") &&  document.getElementById("unsubscription_for_user").querySelectorAll(".option-input").length === 0){
				document.getElementById("another_text_unsub").style.display = "none";
				document.getElementById("hr").style.display = "none";
			}
			if(document.getElementById("hr").style.display === "none" && document.getElementById("subscription_for_user").querySelectorAll(".option-input").length > 0 && document.getElementById("unsubscription_for_user").querySelectorAll(".option-input").length > 0){
				document.getElementById("hr").style.display = "block";
			}
		}
		
	};

	ourRequest.onerror = function() {
	    console.log("Connection error");
	};
	ourRequest.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
	if(send_data.to_subscribe.length !== 0 || send_data.to_unsubscribe.length !== 0){
		ourRequest.send(JSON.stringify(send_data));
	}
	
}



var subs_submit =  document.getElementById("subs_submit");
if(subs_submit){
	subs_submit.addEventListener("click", subs_send_data); 
} 
