<?php

class WGS_Admin_Page {
	
	function __construct() {
		add_action( 'admin_menu', array($this, 'wgs_admin_menu') ) ;
		add_action( 'admin_init', array($this, 'wgs_admin_init') );		
	}		

	function wgs_admin_menu () {
		
		//add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		add_options_page( __('WP Google Search','google-search-plugin-aman'),__('WP Google Search','google-search-plugin-aman')
			,'manage_options','google-search-plugin-aman', array($this, 'add_options_page_callback' ));
	}
	
	
	function wgs_admin_init()
	{
		
		$this->wgs_set_defaults();
	
		//register_setting( $option_group, $option_name, $sanitize_callback );        
		register_setting(
			'aj_gs_general_settings', // Option group / tab page
			'aj_gs_general_settings', // Option name
			array($this, 'sanitize') // Sanitize
		);
	
		add_settings_section(
			'wgs_general_section', // ID 
			__('General Settings','google-search-plugin-aman'), // Title //ML
			array($this,'print_section_info'), // Callback 
			'aj_gs_general_settings' // Page / tab page
		);
		
		//add_settings_field( $id, $title, $callback, $page, $section, $args );

		add_settings_field(
			'google_search_engine_id', // ID
			__('Google Search Engine ID','google-search-plugin-aman'), // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section           
		);

		add_settings_field(
			'searchbox_before_results', // ID
			__('Display search box before search results','google-search-plugin-aman'), // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section           
		);

		add_settings_field(
			'support_overlay_display', // ID
			__('Support Overlay Display','google-search-plugin-aman'), // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section           
		);

		add_settings_field(
			'linktarget_blank', // ID
			__('Link Target Blank','google-search-plugin-aman'), // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section           
		);
		
		add_settings_field(
			'use_default_correction_css', // ID
			__('Use default corrections CSS','google-search-plugin-aman'), // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section           
		);

		// add_settings_field(
		// 	'use_default_correction_css2', // ID
		// 	__('Use default corrections CSS version2','google-search-plugin-aman'), // Title 
		// 	array($this, 'posttype_callback'), // Callback
		// 	'aj_gs_general_settings', // Page / tab page
		// 	'wgs_general_section' // Section           
		// );

		// add_settings_field(
		// 	'use_default_correction_css3', // ID
		// 	__('Use default corrections CSS version3','google-search-plugin-aman'), // Title 
		// 	array($this, 'posttype_callback'), // Callback
		// 	'aj_gs_general_settings', // Page / tab page
		// 	'wgs_general_section' // Section           
		// );

        add_settings_field( //HIDDEN
            'search_gcse_page_id', // ID
            'search_gcse_page_id', // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section               
        );      

        add_settings_field( //HIDDEN
            'search_gcse_page_url', // ID
            'search_gcse_page_url', // Title 
			array($this, 'posttype_callback'), // Callback
			'aj_gs_general_settings', // Page / tab page
			'wgs_general_section' // Section          
        );   
	
	}

	function wgs_set_defaults() {

		$options = get_option( 'aj_gs_general_settings' ); 
					
		$options = wp_parse_args( $options, array(
			'google_search_engine_id' => '', 
			'searchbox_before_results' => '0',
			'linktarget_blank' => '0',
			'support_overlay_display' => '0',
			'use_default_correction_css' => '0', //this is an older css, thus it is not switched on by default
			// 'use_default_correction_css2' => '1',
			// 'use_default_correction_css3' => '0', //this is an optional correction, thus default is 0
		) );
		
		update_option( 'aj_gs_general_settings', $options );
		
	}
	
	function add_options_page_callback()
	{
		
		wp_enqueue_style( 'wgs-admin', plugins_url('wgs-admin.css', __FILE__) );
		
		?>
		<div class="wrap">
			<?php //screen_icon(); ?>
			<h2><?php _e('Google Programmable Search Engine By Aman','google-search-plugin-aman') ?></h2>
			
			<div style="float:left; width: 70%">
			
				<form method="post" action="options.php"><!--form-->  
					
					<?php
		
					settings_fields( 'aj_gs_general_settings' );					
					$options = get_option( 'aj_gs_general_settings' ); //option_name
					
					?>
					<h3><?php _e('General Settings','google-search-plugin-aman') ?></h3>
					<?php 
					//echo __('Enter your settings below','google-search-plugin-aman') . ':' 
					?>
		
					<table class="form-table">
		
						<tr valign="top">
							<th scope="row"><?php echo __('Google Search Engine ID','google-search-plugin-aman') . ':' ?></th>
							<td>
								<?php
						        printf(
						            '<input type="text" id="google_search_engine_id" name="aj_gs_general_settings[google_search_engine_id]" value="%s" size="50" />',
						            esc_attr( $options['google_search_engine_id'])
						        );
								echo '<br /><span class="description">' . __('Register to Google Custom Search Engine and get your Google Search Engine ID here: ','google-search-plugin-aman') . '<a href="https://www.google.com/cse/" target="_blank">https://www.google.com/cse/</a>' . '</span>';
								echo '<br /><span class="description">' . __('You will get a Google Search Engine ID like this: 012345678901234567890:0ijk_a1bcde','google-search-plugin-aman') . '</span>';
								echo '<br /><span class="description">' . __('Enter this Google Search Engine ID here.','google-search-plugin-aman') . '</span>';
						        						        
							    ?>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row"><?php echo __('Display search box before search results','google-search-plugin-aman') . ':' ?></th>
							<td>
								<?php
								printf(
									'<input type="hidden" name="aj_gs_general_settings[searchbox_before_results]" value="0"/>
									<input type="checkbox" id="searchbox_before_results" name="aj_gs_general_settings[searchbox_before_results]"
									value="1"' . checked( 1, esc_attr( $options['searchbox_before_results']), false ) . ' />'
								);
								echo '<br /><span class="description">' . __('If this option is turned on, the search field will appear above the search results.','google-search-plugin-aman') . '</span>';
	
								?>    
							</td>
						</tr>							
			 

						<tr valign="top">
							<th scope="row"><?php echo __('Link Target Blank','google-search-plugin-aman') . ':' ?></th>
							<td>
								<?php
								printf(
									'<input type="hidden" name="aj_gs_general_settings[linktarget_blank]" value="0"/>
									<input type="checkbox" id="linktarget_blank" name="aj_gs_general_settings[linktarget_blank]"
									value="1"' . checked( 1, esc_attr( $options['linktarget_blank']), false ) . ' />'
								);
								echo '<br /><span class="description">' . __('Display content of the links of the result set on new browser tab.','google-search-plugin-aman') . '</span>';
									
								?>    
							</td>
						</tr>							
			 
						<tr valign="top">
							<th scope="row"><?php echo __('Support Overlay Display','google-search-plugin-aman') . ':' ?></th>
							<td>
								<?php
								printf(
									'<input type="hidden" name="aj_gs_general_settings[support_overlay_display]" value="0"/>
									<input type="checkbox" id="support_overlay_display" name="aj_gs_general_settings[support_overlay_display]"
									value="1"' . checked( 1, esc_attr( $options['support_overlay_display']), false ) . ' />'
								);
								echo '<br /><span class="description">' . __('If you set on Google CSE admin page that result set is displayed in Overlay mode, then also set this checkbox. </br>In this case search results will be displayed without loading a new search result page. </br>If you do not use overlay display mode in GCSE, then clear this checkbox, because result set can not be displayed correctly.','google-search-plugin-aman') . '</span>';
									
								?>    
							</td>
						</tr>							
			 
						<tr valign="top">
							<th scope="row"><?php echo __('Use Plugin CSS','google-search-plugin-aman') . ':' ?></th>
							<td>
								<?php
								printf(
									'<input type="hidden" name="aj_gs_general_settings[use_default_correction_css]" value="0"/>
									<input type="checkbox" id="use_default_correction_css" name="aj_gs_general_settings[use_default_correction_css]"
									value="1"' . checked( 1, esc_attr( $options['use_default_correction_css']), false ) . ' />'
								);
								echo '<br /><span class="description">' . __('Activating this option applies CSS to improve search elements look, but theme settings may affect Google Search box styling, possibly requiring custom CSS. Consult your web designer.','google-search-plugin-aman') . '</span>';
									
								?>    
							</td>
						</tr>													
	
						<tr valign="top">
							<th scope="row"><?php echo __('Search Page Target URL','google-search-plugin-aman') . ':' ?></th>
						
							<td>

								<?php						
						        printf(
						            '<input type="hidden" id="search_gcse_page_id" name="aj_gs_general_settings[search_gcse_page_id]" value="%s" />',
						            esc_attr( $options['search_gcse_page_id'])
								);
			
						        printf(
						            '<input type="text" id="search_gcse_page_url" name="aj_gs_general_settings[search_gcse_page_url]" value="%s" size="50" disabled />',
						            esc_attr( get_page_link( $options['search_gcse_page_id'] ))
								);
			
								echo '<br /><span class="description">' . __('The plugin automatically generated a page for displaying search results. You can see here the URL of this page. Please do not delete this page and do not change the permalink of it!','google-search-plugin-aman') . '</span>';								
								?>
							</td>
						</tr>

		
					</table>
					
		
					<?php
					submit_button();
					?>
		
				</form><!--end form-->
	
			</div><!--emd float:left; width: 70% / 100% -->
	
		</div>
		<?php
					
	}
	
	function sanitize( $input )
	{
		if( !is_numeric( $input['id_number'] ) )
			$input['id_number'] = '';  
	
		if( !empty( $input['title'] ) )
			$input['title'] = sanitize_text_field( $input['title'] );
	
		return $input;
	}		
}