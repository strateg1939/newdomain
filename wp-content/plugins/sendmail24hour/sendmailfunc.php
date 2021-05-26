<?php 
function send_mail_subs($user_id, $user_mail, $topic, $topic_id){
 	global $wpdb;
	$articles_to_send = $wpdb->get_results("SELECT article_ID, article_text FROM (SELECT article_ID, article_text FROM articles WHERE day = CURRENT_DATE AND topic_ID = $topic_id) AS a WHERE NOT EXISTS (SELECT 1 FROM connection_user_article WHERE user_ID = $user_id AND article_ID = a.article_ID); ", ARRAY_A);
	foreach ($articles_to_send as $article) {
		$wpdb->query("INSERT INTO `connection_user_article` (user_ID, article_ID) VALUES ($user_id, $article[article_ID]);");
		wp_mail($user_mail, "Your daily $topic article", $article[article_text]);
		
	}
}