<?php

	global $CONFIG;

	$translations = get_installed_translations();
	$plugins = get_plugin_list();
	
	$ts = time();
	$token = generate_action_token($ts);
	
    $issue_types = array('missing', 'potentially_missing', 'non_externalized');		
?>

<script type="text/javascript">

    var loading = '<br /><br /><center><img src="<?php echo $vars['url']; ?>mod/missing_labels/_graphics/loading.gif"></center>';

    $(document).ready(function() {
        $('#missing_labels_results').html(loading);
        var checkUrl = '<?php echo $vars['url']; ?>mod/missing_labels/ajax_actions/check.php';
        $('#missing_labels_results').load(checkUrl);

        $('#missing_labels_submit').click(function() {
            $('#missing_labels_results').html(loading);
			var lang = $('select#language').val();
			var type = $('select#type').val();
			var plugin = $('select#plugin').val();
			var params = Array();
			var paramtext = '';

			if (lang) params.push('language=' + lang);
			if (lang) params.push('type=' + type);
			if (plugin) params.push('plugin=' + plugin);

			if (params.length > 0) {
				paramtext = '?' + params.join('&');
			}
			$('#missing_labels_results').load(checkUrl + paramtext);
        });
    });

</script>
<div class="contentWrapper">
	<div class="missing_labels_menubar">

		<span class="missing_labels_menuitem">
			<?php echo elgg_echo('missing_labels:check'); ?>
			<select id="plugin" name="plugin">
				<option value="0"><?php echo elgg_echo('missing_labels:all_plugins'); ?></option>
			<?php foreach ($plugins as $plugin) { ?>
				<option value="<?php echo $plugin; ?>"><?php echo $plugin; ?></option>
			<?php } ?>
			</select>
		</span>

		<span class="missing_labels_menuitem">
			<?php echo elgg_echo('missing_labels:for'); ?>
			<select id="type" name="type">
			<?php foreach ($issue_types as $issue_type) { ?>
				<option value="<?php echo $issue_type; ?>"><?php echo elgg_echo('missing_labels:issue_type:' . $issue_type); ?></option>
			<?php } ?>
				<option value="all_issues"><?php echo elgg_echo('missing_labels:issue_type:all_issues'); ?></option>
			</select>
		</span>

		<span class="missing_labels_menuitem">
			<?php echo elgg_echo('missing_labels:in'); ?>
			<select id="language" name="language">
			<?php foreach ($translations as $key => $value) { ?>
				<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php } ?>
			</select>
		</span>

		<div>
		    <span class="missing_labels_menuitem">
		        <ul class="clean_results">
		              <li style="display: inline;">
						<button id="missing_labels_submit"><?php echo elgg_echo('missing_labels:go'); ?></button>
		              </li>
		        </ul>
		    </span>
		</div>

	</div>
	<div id="missing_labels_results">
	</div>
</div>