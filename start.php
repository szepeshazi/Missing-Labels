<?php

    /**
     * Missing labels plugin
     * 
     * @package none
     * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
     * @author Andras Szepeshazi
     * @copyright Andras Szepeshazi
     * @link http://wamped.org
     */


    global $CONFIG;

    function missing_labels_init() {
    	
		// Admin menu
    	register_elgg_event_handler('pagesetup','system','missing_labels_adminmenu');
    	        
    }
 
        
    /**
     * Sets up the admin menu.
     */ 
    function missing_labels_adminmenu() {
        if (get_context() == 'admin' && isadminloggedin()) {
            add_submenu_item(elgg_echo('missing_labels:admin:title'), "/mod/missing_labels/admin.php");
        }
    }
    
	
	// Initialise marketplace plugin
	register_elgg_event_handler('init','system','missing_labels_init');
    
?>