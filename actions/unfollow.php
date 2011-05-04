<?php

/**
 * Stop following an entity
 */

$object_guid = get_input('object_guid');

$object = get_entity($object_guid);

if (!$object instanceof ElggEntity) {
	register_error("Could not find the specified entity.  It may have been deleted or you may not have access to it");
	forward(REFERER);
}

if (remove_entity_relationship(elgg_get_logged_in_user_guid(), 'follower', $object_guid)) {
	system_message(elgg_echo("You are no longer following %s", array($object->name)));	
} else {
	register_error(elgg_echo("Something went wrong when attempting to unfollow %s", array($object->name)));
}

forward(REFERER);