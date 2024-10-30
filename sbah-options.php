<?php
//Options Page 

/** Step 2 (from text above). */
add_action( 'admin_menu', 'sbah_plugin_menu' );

/** Step 1. */
function sbah_plugin_menu() {
	 global $sbah_helptab;
    $sbah_helptab = add_submenu_page( 'edit.php?post_type=sbah_helptab', 'Better Admin Help Tabs Options', 'BAH Options', 'manage_options', 'sbah_options', 'sbah_plugin_options');
 // Adds my_help_tab when my_admin_page loads
    add_action('load-'.$sbah_helptab, 'sbah_helptab_add_help_tab');
}

function sbah_helptab_add_help_tab () {
    global $sbah_helptab;
    $screen = get_current_screen();

    /*
     * Check if current screen is My Admin Page
     * Don't add help tab if it's not
     */
    if ( $screen->id != $sbah_helptab )
        return;

    // Add my_help_tab if current screen is Options page
    $screen->add_help_tab( array(
        'id'	=> 'sbah_help_options',
        'title'	=> __('Show Current Screen'),
        'content'	=> '<p>' . __( 'This option, when checked, will load a small bar in the header that tells you what your current screen is. Handy for knowing what to put in the "screen" field.' ) . '</p>',
    ) );
    
}

/** Step 3. */
function sbah_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' , 'better-admin-help-tabs') );
	} ?>
	<div>
 
<form action="options.php" method="post">
<?php settings_fields('sbah_options'); ?>
<?php do_settings_sections('sbah_options'); ?>
<?php submit_button(); ?>
</form></div>
 
<?php
printf( __( '<p>You are running version %s of Better Admin Help Tabs.</p>', 'better-admin-help-tabs' ), sbah_version_init() );


}



 // ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
 
 function sbah_settings_api_init() {
 	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'sbah_setting_section',
		__( 'BAH Options' , 'better-admin-help-tabs'),
		'sbah_setting_section_callback_function',
		'sbah_options'
	);
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
		'sbah_view_cpt',
		__( 'Help Tabs Admin Viewable By:' , 'better-admin-help-tabs'),
		'sbah_setting_callback_function',
		'sbah_options',
		'sbah_setting_section'
	);
	
	add_settings_field(
		'sbah_view_screen',
		__( 'Show Current Screen' , 'better-admin-help-tabs'),
		'sbah_setting_screen_callback_function',
		'sbah_options',
		'sbah_setting_section'
	);
 	
 	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
 	register_setting( 'sbah_options', 'sbah_options' );
 } // sbah_settings_api_init()
 
 add_action( 'admin_init', 'sbah_settings_api_init' );
 
function sbah_version_init() {
$plugin_file = plugin_dir_path( __FILE__ ) . 'better-admin-help-tabs.php';
//echo $plugin_file;
$pdata= get_plugin_data( $plugin_file, $markup = true );
$currVersion = $pdata['Version'];
return $currVersion;
  }
 
  add_action( 'admin_init', 'sbah_version_init' );
 
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
 
 function sbah_setting_section_callback_function() {
 	echo '<p></p>';
 }
 
 // ------------------------------------------------------------------
 // Callback function for our  setting
 // ------------------------------------------------------------------
 //
 //
 
 function sbah_setting_callback_function() {

 global $wp_roles;
 $all_roles = $wp_roles->roles;
 $editable_roles = apply_filters('editable_roles', $all_roles);
 Foreach ($editable_roles as $role) {
 $takenoptions = get_option('sbah_options');
 $takenroles = $takenoptions['sbah_view_cpt'];
 $rolename = $role["name"];

if ($takenoptions['sbah_view_cpt']) {

 if (in_array($rolename,$takenroles) || ($rolename == __( 'Administrator' , 'better-admin-help-tabs'))) {
 $ischecked = 'checked';
 } else {
 $ischecked = '';
 }
 } else {
 
 if (($rolename == __( 'Administrator' , 'better-admin-help-tabs'))) {
 $ischecked = 'checked';
 } else {
 $ischecked = '';
 }
 }
if ($rolename == __( 'Administrator' , 'better-admin-help-tabs')) {
$isdisabled = 'disabled';
} else {
$isdisabled = '';
} 
 echo '<input type="checkbox" id="'.$rolename.'" value="'.$rolename.'" name="sbah_options[sbah_view_cpt][]"' . $ischecked . ' ' . $isdisabled. '/>';
 if ($rolename == __( 'Administrator' , 'better-admin-help-tabs')) {
 echo '<label for="'.$rolename.'">' . __( 'Administrator (Can always see helptabs and is only role to see options page)' , 'better-admin-help-tabs') . '</label><br>';
 } else {
  echo '<label for="'.$rolename.'">'.$rolename.'</label><br>';
 }
 }
 echo '<input type="hidden" id="Administrator" value="Administrator" name="sbah_options[sbah_view_cpt][]" />';
 }
 
  function sbah_setting_screen_callback_function() {
$screenoptions = get_option('sbah_options');
if(isset($screenoptions['sbah_view_screen'][0])) {
$takenscreen = $screenoptions['sbah_view_screen'][0];
} //var_dump($takenscreen);

if(isset($takenscreen)) { 
 $ischecked = 'checked';
 } else {
 $ischecked = '';
 }
 echo '<input type="checkbox" id="sbah_view_screen" value="1" name="sbah_options[sbah_view_screen][0]" '.$ischecked.' />';
 
 }
?>