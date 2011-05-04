<?php

function followers_init() {
	$actions = dirname(__FILE__) . '/actions';
	elgg_register_action('follow', "$actions/follow.php");
	elgg_register_action('unfollow', "$actions/unfollow.php");
}

elgg_register_event_handler('init', 'system', 'followers_init');