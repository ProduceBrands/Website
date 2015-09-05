<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'content'       => array( 
        array(
          'id'        => 'context_general',
          'title'     => 'General',
          'content'   => '<p>Most of the customization options can be found in the <a href="customize.php">WordPress Theme Customizer</a>.</p>
<p>
	<strong>Support</strong>
</p>

<ul>
	<li><a href="http://support.proteusthemes.com">ProteusThemes Support</a></li>
</ul>'
        )
      ),
      'sidebar'       => '<p>
	<strong>Support</strong>
</p>

<ul>
	<li><a href="http://support.proteusthemes.com">ProteusThemes Support</a></li>
</ul>'
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'contact_page_section',
        'title'       => 'Contact page'
      ),
      array(
        'id'          => 'automatic_updates',
        'title'       => 'Automatic Updates'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'user_custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'Custom CSS styles to change the layout and appearance of your website',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'general',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_scripts',
        'label'       => 'Footer Scripts',
        'desc'        => 'Custom scripts for the footer, like Google Analytics tracking script',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '10',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'gm_lat_lng',
        'label'       => 'Longitude and latitude of the map center',
        'desc'        => 'Get this from <a href="https://maps.google.com/">Google Maps</a>, longitude and latitude separated by comma, like <code>40.724885,-74.00264</code> for the New York.',
        'std'         => '46.049467,14.460506',
        'type'        => 'text',
        'section'     => 'contact_page_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'gmap_locations',
        'label'       => 'Google Map Locations',
        'desc'        => '',
        'std'         => 'My business name',
        'type'        => 'list-item',
        'section'     => 'contact_page_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'auto_update_instructions',
        'label'       => 'Auto-update instructions',
        'desc'        => 'If you fill out the two fields below, you will be notified when the theme update is available and you will be able to update with just one click.

Please note, that all the changes you will make in the code directly will be overwritten with the updates. Use the <a href="http://codex.wordpress.org/Child_Themes">Child Themes</a> to alter the code.',
        'std'         => '',
        'type'        => 'textblock',
        'section'     => 'automatic_updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'tf_username',
        'label'       => 'Your username',
        'desc'        => 'Your Envato marketplace (ThemeForest) username.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'automatic_updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'tf_api_key',
        'label'       => 'API key',
        'desc'        => 'Your API key (NOT a password). See <a href="https://www.diigo.com/item/p/pdbsqoszbspabboqezbcoserod" target="_blank">here</a> where you can generate your new API key on ThemeForest site.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'automatic_updates',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}