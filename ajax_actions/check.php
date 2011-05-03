<?php

    /**
     * Missing labels ajax function
     * 
     * @package none
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Andras Szepeshazi
     * @copyright Andras Szepeshazi
     */

    global $CONFIG;
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php');
    gatekeeper();

	// Define potential issues with labels and respective regular expressions to match them in source files
    $label_issues = array(
    	'missing' => array(
			'regexps' => array(
				'/elgg_echo\s*\(\s*["\']([\w:_-]+)["\']\s*\)/',
    		),
    		'results' => array(),
    	),
    	'potentially_missing' => array(
			'regexps' => array(
				'/elgg_echo\s*\(\s*"([\w:_-]*\{\$.*\}[\w:_-]*)"\s*\)/',
				'/elgg_echo\s*\(\s*("[^"]*?"\s*\.\s*\$.*?)\s*\)/',
				'/elgg_echo\s*\(\s*(\'[^\']*?\'\s*\.\s*\$.*?)\s*\)/',
				'/elgg_echo\s*\((\s*\$.*?\.\s*"[^"]*?"\s*)\)/',
				'/elgg_echo\s*\((\s*\$.*?\.\s*\'[^\']*?\'\s*)\)/',
    	),
    		'results' => array(),
    	),
    	'non_externalized' => array(
			'regexps' => array(
				'/\<.+?\>([\w-\s]*?[\w-]+?[\w-\s\,\.\!\?]*?)\<\/{0,1}.+?\>/',
    		),
    		'results' => array(),
    	),
    );
    
	// Define which type of issues should be checked
    $check_issues = array('missing', 'potentially_missing', 'non_externalized');
      
	/**
	 * Checks a given file for all potential issues with labels
	 * 
	 * @param string $filename Full path to the file
	 * @param string $language The two-letted code of the language translation to check
	 */
    function list_labels($filename, $language) {
		global $CONFIG;
		global $label_issues;
		global $check_issues;
		
		$handle = fopen($CONFIG->pluginspath . $filename, "r");
		if ($handle) {
			$size = filesize($CONFIG->pluginspath . $filename);
			if ($size) {
				$contents = fread($handle, $size);
			} else {
				$content = '';
			}
			fclose($handle);
			
			foreach ($label_issues as $issue_type => $issue_details) {
				if (in_array($issue_type, $check_issues)) {
					foreach ($issue_details['regexps'] as $pattern) {
						preg_match_all($pattern, $contents, $matches, PREG_PATTERN_ORDER);
						if (is_array($matches) && !empty($matches[1])) {
							foreach ($matches[1] as $message_key) {
								if (!isset($CONFIG->translations[$language][$message_key])) {
									if (isset($label_issues[$issue_type]['results'][$message_key][$filename])) {
										$label_issues[$issue_type]['results'][$message_key][$filename]++;
									} else {
										$label_issues[$issue_type]['results'][$message_key][$filename] = 1;
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Recursively crawl through directories and pass every php file to the label issue checker
	 * @param string $path The initial path to start from, within the installation's mod directory. Used for narrowing the check domain to any given plugin
	 * @param string $language The two-letted code of the language translation to check
	 */
	function readdir_rec($path, $language) {
		global $CONFIG;
		$exclude_dirs = array('.', '.svn', '..', 'languages');
		if ($handle = opendir($CONFIG->pluginspath . $path)) {
		    while (($file = readdir($handle)) !== false) {
		    	if (is_dir($CONFIG->pluginspath . $path . '/' .$file)) {
					if (!in_array($file, $exclude_dirs)) {
						readdir_rec($path. '/' . $file, $language);
					}
				} else {
					if (substr($file, strlen($file)-4) == '.php') {
						list_labels($path . '/' . $file, $language);
					}
				}
		    }
		    closedir($handle);
		}
		return $labels;
	}
	
	
	// Read form variables
	$start_path = '';

	$selected_plugin = get_input('plugin', 0);
    if ($selected_plugin) {
    	$start_path = $selected_plugin;
    }

    $language = get_input('language', 'en');

    $issue_type = get_input('type', 'missing');
    if ($issue_type != 'all_issues') {
    	$check_issues = array($issue_type);
    }

    // Crawl through all selected directories
	readdir_rec($start_path, $language);

	// Output results
	header("Content-type: text/html; charset=UTF-8");
   	echo elgg_view('missing_labels/results', array('label_issues' => $label_issues, 'check_issues' => $check_issues));
?>