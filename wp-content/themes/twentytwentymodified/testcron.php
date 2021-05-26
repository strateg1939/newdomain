<?php
  /* 
 Template Name: test cron
 */
global $wpdb;
	$topics = $wpdb->get_col('SELECT `topic_name` FROM `topics`;');
	foreach ($topics as $topic) {
		$users = $wpdb->get_col("SELECT `user_ID` FROM `connection_user_topic` WHERE topic_ID = (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$topic');");
		foreach ($users as $user) {
			$user_mail = $wpdb->get_var("SELECT `user_email` FROM `wp_users` WHERE `ID` = $user");
			$articles_to_send = $wpdb->get_results("SELECT `article_ID`,`article_text` FROM `articles` WHERE `article_ID` NOT IN (SELECT `article_ID` FROM `connection_user_article` WHERE `user_ID` = $user) AND `day` = CURRENT_DATE  AND `topic_ID` = (SELECT `topic_ID` FROM `topics` WHERE `topic_name` = '$topic');", ARRAY_A);
			foreach ($articles_to_send as $article) {
				print_r($article);
				echo $user_mail;
				$wpdb->query("INSERT INTO `connection_user_article` (user_ID, article_ID) VALUES ($user, $article[article_ID]);");
				if(!wp_mail($user_mail, "Your daily $topic article", $article[article_text])) echo "failure $user";
			}

		}
	}

