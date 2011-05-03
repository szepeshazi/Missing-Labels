<?php

	include_once dirname(dirname(dirname(__FILE__))) . "/engine/start.php";

	global $CONFIG;

	admin_gatekeeper();
	set_context('admin');
	
	$tab = get_input('tab', 'check');

	extend_view('metatags','missing_labels/css');
	
	$body = elgg_view_title(elgg_echo('missing_labels:admin:title'));
	
	$body .= elgg_view("missing_labels/tabs", array('tab' => $tab));
	$body .= elgg_view("missing_labels/{$tab}");
	
	page_draw(elgg_echo('missing_labels:admin:title'), elgg_view_layout("two_column_left_sidebar", '', $body));

?>
