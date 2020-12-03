<?php
/*
Plugin name: send mail 24 hours
Version: 1.0
*/


add_action( 'admin_head', 'my_activation' );
function my_activation() {
	if( ! wp_next_scheduled( 'my_daily_event' ) ) {
		wp_schedule_event( time(), 'daily', 'my_daily_event');
	}
}


add_action( 'my_daily_event', 'send_mail_to_subs' );
function send_mail_to_subs(){
	global $wpdb;
	$topics = $wpdb->get_col('SELECT `topic_name` FROM `topics`;');
	foreach ($topics as $topic) {
		$users = $wpdb->get_col("SELECT `user_ID` FROM `connection_user_topic` WHERE topic_ID = (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$topic');");
		foreach ($users as $user) {
			$user_mail = $wpdb->get_var("SELECT `user_email` FROM `wp_users` WHERE `ID` = $user");
			$articles_to_send = $wpdb->get_results("SELECT `article_ID`,`article_text` FROM `articles` WHERE `article_ID` NOT IN (SELECT `article_ID` FROM `connection_user_article` WHERE `user_ID` = $user) AND `day` = CURRENT_DATE  AND `topic_ID` = (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$topic');", ARRAY_A);
			foreach ($articles_to_send as $article) {
				$wpdb->query("INSERT INTO `connection_user_article` (user_ID, article_ID) VALUES ($user, $article[article_ID]);");
				wp_mail($user_mail, "Your daily $topic article", $article[article_text]);
			}

		}
	}
}
register_deactivation_hook( __FILE__, 'my_deactivation' );
function my_deactivation(){
	wp_clear_scheduled_hook( 'my_daily_event' );
}