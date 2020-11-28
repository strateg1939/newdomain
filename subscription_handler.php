<?php
  /* 
 Template Name: Subscribtion handle
 */  
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
	if(strlen($key) !== strlen($value)){
		$wpdb->query("DELETE FROM `connection_user_topic` WHERE topic_ID =  (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$value') AND user_ID = $user_id;");
	}
	else{
		$wpdb->query("INSERT INTO `connection_user_topic`(`user_ID`, `topic_ID`) VALUES ($user_ID, (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$value'));");
		$articles_to_send = $wpdb->get_results("SELECT `article_ID`,`article_text` FROM `articles` WHERE `article_ID` NOT IN (SELECT `article_ID` FROM `connection_user_article` WHERE `user_ID` = $user_id) AND `day` = CURRENT_DATE  AND `topic_ID` IN (SELECT `topic_ID` FROM `connection_user_topic` WHERE `user_ID` = $user_id); ", ARRAY_A);
		foreach ($articles_to_send as $article) {
			$wpdb->query("INSERT INTO `connection_user_article` (user_ID, article_ID) VALUES ($user_id, $article[article_ID]);");
			//if(!wp_mail($user_mail, "Your daily $value article", $article[article_text])) echo "failure";


		}
	}
 } 

 echo "Your subscribtion were changed";
 echo '<p><a href = '.home_url().'>return to home page</a></p>';
 get_footer();

 ?>