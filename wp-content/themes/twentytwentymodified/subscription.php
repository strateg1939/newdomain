<?php
  /* 
 Template Name: Subscription form
 */  
 if(!is_user_logged_in()){
 	wp_redirect("http://newdomain/my-account");
 } 
 get_header();  
global $wpdb;


$user_id = wp_get_current_user()->ID;
$topics_for_user_sub = $wpdb->get_col("SELECT topic_name FROM `topics` WHERE topic_ID NOT IN 
 		(SELECT topic_ID FROM `connection_user_topic` WHERE user_ID = $user_ID);");
echo '<form action="http://newdomain/user_sub/" method="post">' ; 

if(count($topics_for_user_sub) !== 0){
	echo '<span class = "checkbox_text" id = "another_text"> Here are topics you can subscribe to and get daily articles about :</span><br><br>';	 
 	foreach ($topics_for_user_sub as $topic) {
 		echo  "<p><input type='checkbox' name='$topic' value='$topic' class = 'option-input'><span class = 'checkbox_text'> $topic </span></p>";
 	}
 
}
$topics_for_user_unsub = $wpdb->get_col("SELECT topic_name FROM `topics` WHERE topic_ID IN 
 		(SELECT topic_ID FROM `connection_user_topic` WHERE user_ID = $user_ID);");
if(count( $topics_for_user_unsub) !== 0){
	if(count($topics_for_user_sub) !== 0){
		echo '<hr>';
	}
 echo '<span class = "checkbox_text" id = "another_text"> And here you can unsubscribe from topics if you no longer want to receive emails: </span><br><br>
 <form action="http://newdomain/user_unsub/" method="post">';
 	foreach ($topics_for_user_unsub as $topic) {
 		echo  "<p><input type='checkbox' name='a.$topic' value='$topic' class = 'option-input'> <span class = 'checkbox_text'> $topic </span></p>";
 	}
}
echo '<input type="submit" name="submit" value="submit" id = "subs_submit">';
echo '</form>';


 get_footer();  
