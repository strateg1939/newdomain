<?php
  /* 
 Template Name: Subscription form
 */  
if(!is_user_logged_in()){
 	wp_redirect("http://newdomain/my-account");
} 

global $wpdb;
$user_id = wp_get_current_user()->ID;
$user_mail = wp_get_current_user()->user_email;

wp_register_script(
    'get_id',
     get_template_directory_uri() . '/js/subs.js',
     array( 'jquery' ),
     1.3,
     true
);

wp_enqueue_script( 'get_id' );

wp_localize_script( 'get_id', 'params', array( 'id' => $user_id, 'mail' => $user_mail ) );
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

function theme_name_scripts() {
	wp_enqueue_style( 'subs_styles', get_template_directory_uri().'/subs_styles.css',array(), '1.0' );
}

get_header();  



echo "<span class = 'checkbox_text' id = 'response_text' style = 'display : none'> Your subscriptions were changed </span> <hr id = 'response_text_hr' style = 'display : none'>";
$topics_for_user_sub = $wpdb->get_results("SELECT topic_name,topic_ID FROM `topics` WHERE topic_ID NOT IN 
 		(SELECT topic_ID FROM `connection_user_topic` WHERE user_ID = $user_ID);", ARRAY_A);

echo "<div id = 'subscription_for_user'>";
echo "<span class = 'checkbox_text' id = 'another_text_sub' ";
if(count($topics_for_user_sub) === 0){
	echo "style = 'display: none;'";
}

echo '> Here are topics you can subscribe to and get daily articles about :</span><br><br>';
if(count($topics_for_user_sub) !== 0){	 
 	foreach ($topics_for_user_sub as $topic) {
 		echo  "<p><input type='checkbox' name='$topic[topic_ID]' value='$topic[topic_name]' class = 'option-input' id = '$topic[topic_name]'><span class = 'checkbox_text' id = '$topic[topic_name].text'> $topic[topic_name] </span></p>";
 	}
}
echo "</div><div id = 'unsubscription_for_user'>";
$topics_for_user_unsub = $wpdb->get_results("SELECT topics.topic_name,topics.topic_ID FROM `topics` INNER JOIN connection_user_topic on topics.topic_ID = connection_user_topic.topic_ID WHERE connection_user_topic.user_ID = $user_id;", ARRAY_A);
echo '<hr id = "hr" ';
if(count( $topics_for_user_unsub) == 0 || count( $topics_for_user_sub) == 0){
		echo 'style = "display: none;"';
}
echo '><span class = "checkbox_text" id = "another_text_unsub" ';
if(count( $topics_for_user_unsub) === 0){
	echo 'style = "display: none;"';
}
echo '> And here you can unsubscribe from topics if you no longer want to receive emails: </span><br><br>
 ';
if(count( $topics_for_user_unsub) !== 0){
 	foreach ($topics_for_user_unsub as $topic) {
 		echo  "<p><input type='checkbox' name='$topic[topic_ID]' value='$topic[topic_name]' class = 'option-input' id = '$topic[topic_name]'> <span class = 'checkbox_text' id = '$topic[topic_name].text'> $topic[topic_name] </span></p>";
 	}
}
echo "</div>";
echo '<input type="submit" name="submit" value="submit" id = "subs_submit">';



 get_footer();  
