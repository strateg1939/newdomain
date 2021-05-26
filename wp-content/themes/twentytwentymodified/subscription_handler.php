<?php
  /* 
 Template Name: Subscription handle
 */  
 require_once('d:\OpenServer\domains\newdomain\wp-content\plugins\sendmail24hour\sendmailfunc.php');
 get_header();
 if(count($_POST) == 1){
 	echo "You haven`t changed anything";
 	echo '<p><a href = "http://newdomain/topicstochange/">return to subscribing</a></p>';
 	echo '<p><a href = '.home_url().'>return to home page</a></p>';
 	return;
 }
 unset($_POST['submit']);
 global $wpdb;
 $user_id = wp_get_current_user()->ID;
 $user_mail = wp_get_current_user()->user_email;
 foreach ($_POST as $key => $value) {
 	$topic_id = $wpdb->get_var("SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$value'");
	if(strlen($key) !== strlen($value)){
		$wpdb->query("DELETE FROM `connection_user_topic` WHERE topic_ID =  $topic_id AND user_ID = $user_id;");
	}
	else{
		$wpdb->query("INSERT INTO `connection_user_topic`(`user_ID`, `topic_ID`) VALUES ($user_id, $topic_id);");
		send_mail_subs($user_id, $user_mail, $value, $topic_id);
		
	}
 } 

 echo "Your subscriptions were changed";
 echo '<p><a href = '.home_url().'>return to home page</a></p>';


 get_footer();




 ?>