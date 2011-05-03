<?php 
	
	global $CONFIG;
	
	$label_issues = $vars['label_issues'];
	$check_issues = $vars['check_issues'];

	foreach ($label_issues as $issue_type => $issue_details) {
		if (in_array($issue_type, $check_issues)) {
			if (count($issue_details['results'])) {
	
?>

		<table class="missing_labels_results">
			<thead>
				<tr>
					<th scope="col" id="headcol1"><?php echo elgg_echo('missing_labels:issue_type:' . $issue_type); ?></th>
					<th scope="col" id="headcol2"><?php echo elgg_echo('missing_labels:results:occurence'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach ($issue_details['results'] as $label => $details) {
			?>
				<tr>
					<td>
						<strong>
							<span><?php echo $label; ?></span>
							<span>
								<a class="externalize_label" href="#">
									<img src="<?php echo $CONFIG->wwwroot;?>mod/missing_labels/_graphics/externalize.png" title="<?php echo elgg_echo('missing_labels:externalize:label'); ?>"></img>
								</a>
							</span>
							<span>
								<a class="ignore_label" href="#">
									<img src="<?php echo $CONFIG->wwwroot;?>mod/missing_labels/_graphics/delete_icon.png" title="<?php echo elgg_echo('missing_labels:ignore:label'); ?>"></img>
								</a>
							</span>
						</strong>
					</td>
					<td>
						<?php 
							foreach ($details as $key => $value) {
								echo '<span>' . $key . ' - ' . $value . ' time(s)</span>';
						?>
						<span>
							<a class="ignore_file" href="#">
								<img src="<?php echo $CONFIG->wwwroot;?>mod/missing_labels/_graphics/delete_icon.png" title="<?php echo elgg_echo('missing_labels:ignore:file'); ?>"></img>
							</a>
						</span>
						<br />
						<?php } ?>
					</td>
				</tr>
			<?php 
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th scope="col" id="headcol1"><?php echo elgg_echo('missing_labels:results:total'); ?></th>
					<th scope="col" id="headcol1"><?php echo count($issue_details['results']); ?></th>
				</tr>
			</tfoot>	
		</table>
<?php
			} else { 
?>		
		<div>
		    <span>
		        <ul class="clean_results">
		              <li class="clean_results"><?php echo elgg_echo("missing_labels:{$issue_type}:clean");?></li>
		        </ul>
		    </span>
		</div>
<?php 
			}
		}
	}
?>