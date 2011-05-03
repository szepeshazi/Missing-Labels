<?php 

	$tab = $vars['tab'];
	$url = $vars['url'] . "mod/missing_labels/admin.php?tab=";	
?>

<div id="elgg_horizontal_tabbed_nav">
<ul>
	<li <?php if($tab == 'check') echo "class = 'selected'"; ?>><a href="<?php echo $url; ?>check"><?php echo elgg_echo('missing_labels:tab:check'); ?></a></li>
	<li <?php if($tab == 'ignore') echo "class = 'selected'"; ?>><a href="<?php echo $url; ?>ignore"><?php echo elgg_echo('missing_labels:tab:ignore'); ?></a></li>
</ul>
</div>