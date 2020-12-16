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
	require_once("sendmailfunc.php");
	$mails_to_send = $wpdb->get_results("SELECT topics.topic_ID, topics.topic_name, connection_user_topic.user_ID, wp_users.user_email FROM ((topics INNER JOIN connection_user_topic ON topics.topic_ID = connection_user_topic.topic_ID) INNER JOIN wp_users ON connection_user_topic.user_ID = wp_users.ID)", ARRAY_A);
	foreach ($mails_to_send as $mail) {
			send_mail_subs($mail[user_ID], $mail[user_email],$mail[topic_name], $mail[topic_ID]);
	}

}


register_deactivation_hook( __FILE__, 'my_deactivation' );
function my_deactivation(){
	wp_clear_scheduled_hook( 'my_daily_event' );
}



add_action( 'rest_api_init', function () {
  register_rest_route( 'sendsubs/v1', 'user/(?P<id>\d+)', array(
    'methods' => 'POST',
    'callback' => 'change_subscriptions',
  ) );
} );

function change_subscriptions($data) {
	global $wpdb;
    require_once("sendmailfunc.php");
 	$subscription =  $data->get_json_params();
 	$user_mail = $subscription[mail];
 	foreach ($subscription[to_subscribe] as $topic_id => $topic_name) {
 		$wpdb->query("INSERT INTO `connection_user_topic`(`user_ID`, `topic_ID`) VALUES ($data[id], $topic_id);");
		send_mail_subs($data['id'], $user_mail, $topic_name, $topic_id);
 	}
 	unset($topic_id);
 	unset($topic_name);
 	foreach ($subscription[to_unsubscribe] as $topic_id => $topic_name) {
 		$wpdb->query("DELETE FROM `connection_user_topic` WHERE topic_ID =  $topic_id AND user_ID = $data[id];");
 	}
 	return "success";
}
