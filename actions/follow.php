<?php

/**
 * Start following an entity
 */

$object_guid = get_input('object_guid');

$object = get_entity($object_guid);

if (!$object instanceof ElggEntity) {
	register_error(elgg_echo('followers:follow:error:noentity'));
	forward(REFERER);
}

if (add_entity_relationship(elgg_get_logged_in_user_guid(), 'follower', $object_guid)) {
	system_message(elgg_echo('followers:follow:success', array($object->name)));
} else {
	register_error(elgg_echo('followers:follow:error:unknown', array($object->name)));
}

forward(REFERER);