<?php

/**
 * Stop following an entity
 */

$object_guid = get_input('object_guid');

$object = get_entity($object_guid);

if (!$object instanceof ElggEntity) {
	register_error(elgg_echo('followers:unfollow:error:noentity'));
	forward(REFERER);
}

if (remove_entity_relationship(elgg_get_logged_in_user_guid(), 'follower', $object_guid)) {
	system_message(elgg_echo("followers:unfollow:success", array($object->name)));
} else {
	register_error(elgg_echo("followers:unfollow:error:unknown", array($object->name)));
}

forward(REFERER);