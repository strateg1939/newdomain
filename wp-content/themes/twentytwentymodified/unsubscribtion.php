<?php
  /* 
 Template Name: Unsubscribtion handle
 */  
 get_header();
  if(count($_POST) == 1){
 	echo "You haven`t unsubscribed from anything";
 	echo '<p><a href = "http://newdomain/topicstochange/">return to subscribing</a></p>';
 	echo '<p><a href = '.home_url().'>return to home page</a></p>';
 	return;
 }
unset($_POST['submit']);
 global $wpdb;
 $user_id = wp_get_current_user()->ID;
foreach ($_POST as $value) {
	$wpdb->query("DELETE FROM `connection_user_topic` WHERE topic_ID =  (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$value') AND user_ID = $user_id;");
}
 echo "You are unsubscribed";
 echo '<p><a href = '.home_url().'>return to home page</a></p>';
 get_footer();

 ?>