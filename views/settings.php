<div class="wrap">
    <h2><?php echo $this->plugin->displayName; ?> &raquo; <?php _e('Settings', $this->plugin->name); ?></h2>
           
    <?php    
    if (isset($this->message)) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>  
        <?php
    }
    if (isset($this->errorMessage)) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>  
        <?php
    }
    ?> 
    
    <div id="poststuff">
    	<div id="post-body" class="metabox-holder columns-2">
    		<!-- Content -->
    		<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">                        
	                <div class="postbox">
	                    <h3 class="hndle"><?php _e('Settings', $this->plugin->name); ?></h3>
	                    
	                    <div class="inside">
		                    <form action="options-general.php?page=<?php echo $this->plugin->name; ?>" method="post">
								<?php wp_nonce_field($this->plugin->name, $this->plugin->name.'_nonce'); ?>
		                    	<p>
		                    		<label for="chat_robot_script_insert"><strong><?php _e('Install Chat-Robot on the website.', $this->plugin->name); ?></strong></label><br>
	                    		<p>	
                                <div class="message-field">
                                    <label><?php _e('Insert your token:', $this->plugin->name); ?></label>
                                    <input type="text" id="chat_robot_script_token" name="chat_robot_script_token" value="<?= $this->settings['chat_robot_script_token'] ?> "></input> 
                                    <p class="description"><label for="wpcf7-message-invalid-required"><?php _e('Your token is get for the system on "Settings->[YOUR-SOURCES]->Domains.', $this->plugin->name); ?> </label></p>
                                </div>
                                <br>
		                    	<div class="message-field">
									<input type="checkbox" id="chat_robot_script_insert" name="chat_robot_script_insert" value="1" <?= $this->settings['chat_robot_script_insert'] == "1" ? 'checked="checked"' : ''; ?>></input> 
	                    			<?php _e('Active ChatRobot', $this->plugin->name); ?>
								</div>
		                    	<p>
									<input name="submit" type="submit" name="Submit" class="button button-primary" value="<?php _e('Save', $this->plugin->name); ?>" /> 
								</p>
						    </form>
	                    </div>
	                </div>
	                <!-- /postbox -->
				</div>
				<!-- /normal-sortables -->
    		</div>
    		<!-- /post-body-content -->
    		
    		<!-- Sidebar -->
    		<div id="postbox-container-1" class="postbox-container">
    			<?php //require_once($this->plugin->folder.'/_modules/dashboard/views/sidebar-admin.php'); ?>		
    		</div>
    		<!-- /postbox-container -->
    	</div>
	</div>      
</div>