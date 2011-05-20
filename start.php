<?php

function followers_init() {
	$actions = dirname(__FILE__) . '/actions';
	elgg_register_action('follow', "$actions/follow.php");
	elgg_register_action('unfollow', "$actions/unfollow.php");
	
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'followers_user_hover_menu');
	
	if (elgg_is_logged_in()) {
		$user = elgg_get_logged_in_user_entity();
		elgg_register_menu_item('filter', array(
			'name' => 'following',
			'href' => "/activity/following",
			'text' => "Following",
			'priority' => 500,
		));
	}
	
	global $CONFIG, $following_original_activity_page_handler;
	$following_original_activity_page_handler = $CONFIG->pagehandler['activity'];
	elgg_register_page_handler('activity', 'followers_activity_page_handler');
}

function followers_activity_page_handler($segments, $handle) {
	switch ($segments[0]) {
		case 'following':
			require_once dirname(__FILE__) . '/pages/activity/following.php';
			return;
		default:
			global $following_original_activity_page_handler;
			return call_user_func($following_original_activity_page_handler, $segments, $handle);
	}
}

function followers_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];

	if (elgg_is_logged_in() && elgg_get_logged_in_user_guid() != $user->guid) {
		
		if (check_entity_relationship(elgg_get_logged_in_user_guid(), 'follower', $user->guid)) {
			$url = elgg_add_action_tokens_to_url("action/unfollow?object_guid=$user->guid");
			$item = new ElggMenuItem('unfollow', elgg_echo('unfollow:user'), $url);
		} else {
			$url = elgg_add_action_tokens_to_url("action/follow?object_guid=$user->guid");
			$item = new ElggMenuItem('follow', elgg_echo('follow:user'), $url);
		}
		
		$item->setSection('action');
		$return[] = $item;
	}

	return $return;
}

elgg_register_event_handler('init', 'system', 'followers_init');