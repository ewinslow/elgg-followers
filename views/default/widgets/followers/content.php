<?php

echo elgg_list_entities_from_relationship(array(
	'type' => 'user',
	'relationship' => 'follower',
	'relationship_guid' => elgg_get_page_owner_guid(),
	'inverse_relationship' => true,
));