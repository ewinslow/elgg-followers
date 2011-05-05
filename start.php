<?php

function followers_init() {
	$actions = dirname(__FILE__) . '/actions';
	elgg_register_action('follow', "$actions/follow.php");
	elgg_register_action('unfollow', "$actions/unfollow.php");
	
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'followers_user_hover_menu');
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