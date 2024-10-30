<?php
/**
* Plugin Name: Chat Robot
* Plugin URI: https://www.chat-robot.com/
* Description: This plugin insert the script of ChatRobot in your WordPress.
* Version: 1.0
* Author: Chat Robot
* Author URI: https://www.chat-robot.com/
* License: A "Slug" license name e.g. GPL12
*/

/**
* Insert Headers and Footers Class
*/
class InsertScriptCR {
/**
	* Constructor
	*/
	public function __construct() {

		// Plugin Details
        $this->plugin               = new stdClass;
        $this->plugin->name         = 'chat-robot'; // Plugin Folder
        $this->plugin->displayName  = 'Chat Robot'; // Plugin Name
        $this->plugin->version      = '1.0';
        $this->plugin->folder       = plugin_dir_path( __FILE__ );
        $this->plugin->url          = plugin_dir_url( __FILE__ );

		// Hooks
		add_action('admin_init', array(&$this, 'registerSettings'));
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
        
        // Frontend Hooks
		add_action('wp_footer', array(&$this, 'frontendFooter'));
	}


	/**
	* Register Settings
	*/
	function registerSettings() {
		register_setting($this->plugin->name, 'chat_robot_script_insert', 'trim');
		register_setting($this->plugin->name, 'chat_robot_script_token', 'trim');
	}

	/**
    * Register the plugin settings panel
    */
    function adminPanelsAndMetaBoxes() {
    	add_submenu_page('options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array(&$this, 'adminPanel'));
	}

	/**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
    	// Save Settings
        if (isset($_POST['submit'])) {
        	// Check nonce
        	if (!isset($_POST[$this->plugin->name.'_nonce'])) {
	        	// Missing nonce	
	        	$this->errorMessage = __('nonce field is missing. Settings NOT saved.', $this->plugin->name);
        	} elseif (!wp_verify_nonce($_POST[$this->plugin->name.'_nonce'], $this->plugin->name)) {
	        	// Invalid nonce
	        	$this->errorMessage = __('Invalid nonce specified. Settings NOT saved.', $this->plugin->name);
        	} else {        	
	        	//Sanitize, validation inputs and save
	        	$save_insert = intval( $_POST['chat_robot_script_insert']);
	        	if ( !$save_insert || strlen( $save_insert ) > 1)
					$save_insert = 0;

				$save_token = sanitize_text_field( wp_strip_all_tags( $_POST['chat_robot_script_token'] ) );
				if(!ctype_alnum($save_token))
					$save_token = "";
				
				//Updates values
	    		update_option('chat_robot_script_insert', $save_insert);
	    		update_option('chat_robot_script_token', $save_token);

	    		if(strlen( $save_token ) != 32 && !empty($save_token))
					$this->errorMessage = __('The token is invalid. Must have 32 alphanumeric characters.', $this->plugin->name);
				else if(empty($save_token) && $save_insert == 1)
					$this->errorMessage = __('Chat Robot is activated but not have token, this chat not will start.', $this->plugin->name);
				else if($save_insert == 0)
					$this->message = __('Chat Robot is disabled.', $this->plugin->name);
				else
					$this->message = __('Chat Robot is enabled.', $this->plugin->name);
			}
        }
        
        // Get latest settings
        $this->settings = array(
        	'chat_robot_script_token' => sanitize_text_field(stripslashes(get_option('chat_robot_script_token'))),
        	'chat_robot_script_insert' => sanitize_text_field(stripslashes(get_option('chat_robot_script_insert')))
        );
        
    	// Load Settings Form
        include_once(WP_PLUGIN_DIR.'/'.$this->plugin->name.'/views/settings.php');  
    }

	/**
	* Loads plugin textdomain
	*/
	function loadLanguageFiles() {
		load_plugin_textdomain($this->plugin->name, false, $this->plugin->name.'/languages/');
	}

	/**
	* Outputs script / CSS to the frontend footer
	*/
	function frontendFooter() {
		if(get_option('chat_robot_script_insert') == 1){
			// Ignore admin, feed, robots or trackbacks
			if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
				return;
			}
			
			// Get meta
			$token = get_option('chat_robot_script_token');
			if(strlen( $token ) != 32)
				$token = "";

			$result = '<script type="application/javascript" src="//script2.chat-robot.com' . (!empty($token) ? '/?token='.sanitize_text_field( wp_strip_all_tags($token)) : '/') . '"></script>';
			
			// Output
			echo stripslashes($result);
		}
	}
}
		
$crInsertScript = new InsertScriptCR();