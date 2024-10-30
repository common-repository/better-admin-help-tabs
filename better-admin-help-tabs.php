<?php
/* Plugin Name: Better Admin Help Tabs
Plugin URI: http://stephensuess.com/
Description: Admin Help Tabs for WP Admin. These will work on any post type or page.
Version: 1.3.4
Author: Stephen Suess
Text Domain: better-admin-help-tabs
Domain Path: /languages
Author URI: http://stephensuess.com/
License: GPLv2 or later
*/


function sbah_activation() {
}
register_activation_hook(__FILE__, 'sbah_activation');
function sbah_deactivation() {
}
register_deactivation_hook(__FILE__, 'sbah_deactivation');

function sbah_load_plugin_textdomain() {
    load_plugin_textdomain( 'better-admin-help-tabs', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'sbah_load_plugin_textdomain' );


// LINK LOVE
function sbah_custom_plugin_row_meta( $links, $file ) {
 
   if ( strpos( $file, 'better-admin-help-tabs.php' ) !== false ) {
      $new_links = array(
               '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40c%2esatoristephen%2ecom&lc=US&item_name=Stephen%20Suess&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" target="_blank">' . __( 'Donate', 'better-admin-help-tabs' ) . '</a>',
            );
       
      $links = array_merge( $links, $new_links );
   }
    
   return $links;
}
 
add_filter( 'plugin_row_meta', 'sbah_custom_plugin_row_meta', 10, 2 );

include_once( dirname( __FILE__ ) . '/sbah-options.php');

add_action('init', 'sbah_helptabs_register_helptab');

function sbah_helptabs_register_helptab() {

    $labels = array(

		'name'               => _x( 'Help Tabs', 'post type general name', 'better-admin-help-tabs' ),
		'singular_name'      => _x( 'Help Tab', 'post type singular name', 'better-admin-help-tabs' ),
		'menu_name'          => _x( 'Help Tabs', 'admin menu', 'better-admin-help-tabs' ),
		'name_admin_bar'     => _x( 'Help Tab', 'add new on admin bar', 'better-admin-help-tabs' ),
		'add_new'            => _x( 'Add New', 'helptab', 'better-admin-help-tabs' ),
		'add_new_item'       => __( 'Add New Help Tab', 'better-admin-help-tabs' ),
		'new_item'           => __( 'New Help Tab', 'better-admin-help-tabs' ),
		'edit_item'          => __( 'Edit Help Tab', 'better-admin-help-tabs' ),
		'view_item'          => __( 'View Help Tab', 'better-admin-help-tabs' ),
		'all_items'          => __( 'All Help Tabs', 'better-admin-help-tabs' ),
		'search_items'       => __( 'Search Help Tabs', 'better-admin-help-tabs' ),
		'parent_item_colon'  => __( 'Parent Help Tabs:', 'better-admin-help-tabs' ),
		'not_found'          => __( 'No help tabs found.', 'better-admin-help-tabs' ),
		'not_found_in_trash' => __( 'No help tabs found in Trash.', 'better-admin-help-tabs' ),
    );

    $args = array(

       'labels' => $labels,

       'hierarchical' => true,

       'description' => 'Help Tabs',
        
       'menu_icon' => 'dashicons-editor-help',

       'supports' => array('title', 'editor'),

       'public' => true,

       'show_ui' => true,

       'show_in_menu' => true,

       'show_in_nav_menus' => true,

       'publicly_queryable' => false,

       'exclude_from_search' => true,

       'has_archive' => false,

       'query_var' => true,

       'can_export' => true,

       'rewrite' => true,

       'capability_type' => 'post'

    );

    register_post_type('sbah_helptab', $args);

}


//INITIALIZE THE METABOX CLASS

function sbah_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once(plugin_dir_path( __FILE__ ) . 'cmbclass/init.php');
}

add_action( 'init', 'sbah_initialize_cmb_meta_boxes', 9999 );


//Add Meta Boxes to help

function sbah_helptab_metaboxes( $meta_boxes ) {
	$prefix = '_sbah_'; // Prefix for all fields

	$meta_boxes[] = array(
		'id' => 'sht_metabox',
		'title' => 'Help Tabs Box info',
		'pages' => array('sbah_helptab'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __( 'Screen', 'better-admin-help-tabs' ),
				'desc' => __( 'What screen will this show up on (example: my-custom-post-type). Separate multiple screens with comma or space.', 'better-admin-help-tabs' ),
				'id' => $prefix . 'screen_text',
				'type' => 'text'
			),		
			array(
				'name' => __( 'Type', 'better-admin-help-tabs' ),
				'desc' => __( 'What type of help item is this?', 'better-admin-help-tabs' ),
				'id' => $prefix . 'type_radio',
				'type'    => 'radio',
				'default' => 'tab',
    			'options' => array(
        			'tab' => __( 'Tab', 'better-admin-help-tabs' ),
        			'sidebar'   => __( 'Sidebar', 'better-admin-help-tabs' ),
   				 ),
			),			
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'sbah_helptab_metaboxes' );


//CUSTOMIZE THE COLUMNS

add_filter( 'manage_edit-sbah_helptab_columns', 'my_edit_sbah_helptab_columns' ) ;

function my_edit_sbah_helptab_columns( $columns ) {

	$columns = array(
		'title' => __( 'Help Tab Title' , 'better-admin-help-tabs'),
		'_sbah_screen_text' => __( 'Screen/Page' , 'better-admin-help-tabs'),
		'_sbah_type_radio' => __( 'Type' , 'better-admin-help-tabs'),
		'date' => __( 'Date' , 'better-admin-help-tabs')
	);

	return $columns;
}

add_action( 'manage_sbah_helptab_posts_custom_column', 'my_manage_sbah_helptab_columns', 10, 2 );

function my_manage_sbah_helptab_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'screen' column. */
		case '_sbah_screen_text' :

			/* Get the post meta. */
			$screentext = get_post_meta( $post_id, '_sbah_screen_text', true );

			/* If no screentext is found, output a default message. */
			if ( empty( $screentext ) )
				echo __( 'Unknown' , 'better-admin-help-tabs');
			else
			echo $screentext;
			break;

		/* If displaying the 'type' column. */
		case '_sbah_type_radio' :

			/* Get the post meta. */
			$targettext = get_post_meta( $post_id, '_sbah_type_radio', true );

			/* If no target is found, output a default message. */
			if ( empty( $targettext ) )
				echo __( 'Unknown' , 'better-admin-help-tabs');
			echo $targettext;

			break;
			
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}



function makeHelptabQuery(){
//$helptab_query = array();
global $post_ID;
$screen = get_current_screen();
if (!$screen)
return;
$idofscreen = $screen->id;

$qargs = array(
   'post_type' => 'sbah_helptab',
   'posts_per_page' => '-1',
   'meta_query' => array(
       array(
           'key' => '_sbah_screen_text',
           'value' => '(^|[^-])[[:<:]]'.$idofscreen.'($|[[:>:]][^-])',
           'compare' => 'REGEXP',
       )
   )
 );

$the_querying = get_posts($qargs);
foreach ( $the_querying as $post ) : setup_postdata( $post );
        $hscreen = get_post_meta($post->ID, '_sbah_screen_text', true );
        $htype = get_post_meta($post->ID, '_sbah_type_radio', true );
        $htitle = get_the_title($post->ID);
        $hcontent = apply_filters('the_content', $post->post_content);
if ( $screen->id != null ) {
if ($htype == 'tab') {
$screen->add_help_tab( array(
'id' => $post->ID, //unique id for the tab
'title' => $htitle, //unique visible title for the tab
'content' => '<p></p>' . $hcontent, //actual help text
));
} else {
$hscontent ='<h5>'.$htitle. '</h5>' . $hcontent . '<p></p>';
$screen->set_help_sidebar($hscontent);
}}

            
endforeach; 
wp_reset_postdata();
}    


add_action('admin_head', 'makeHelptabQuery');



// GET CURRENT USER ROLE
function get_help_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    return $user_role;
}

//REMOVE helptabs CPT IF USER ROLE NOT IN LIST

function sbah_remove_menu_items() {
 $takenoptions = get_option('sbah_options');
 if ($takenoptions['sbah_view_cpt']) {
 $takenroles = array_map('strtolower', $takenoptions['sbah_view_cpt']);
 if (!in_array(get_help_user_role(),$takenroles)) {
        remove_menu_page( 'edit.php?post_type=sbah_helptab' );
    }
} else {

if (get_help_user_role() != 'administrator') {
        remove_menu_page( 'edit.php?post_type=sbah_helptab' );
}
}
}

add_action( 'admin_menu', 'sbah_remove_menu_items' );


//SHOW SCREEN IF OPTION CHECKED

add_action( 'admin_notices', 'sbah_show_current_screen' );
function sbah_show_current_screen() {
$screenoptions = get_option('sbah_options');
if(isset($screenoptions['sbah_view_screen'][0])) {
$takenscreen = $screenoptions['sbah_view_screen'][0];
}
 //var_dump($takenscreen);
if(isset($takenscreen)) { 

	if( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;
	
	global $current_screen;
	
	echo "<div id='screennotice' style='border:1px solid black;background:white;padding:10px;margin-top:15px;float:left;'><strong>This is your current screen ID ( You can turn this off <a href='/wp-admin/edit.php?post_type=sbah_helptab&page=sbah_options'>here</a> ) :</strong>  <span style='color:red;'>".$current_screen->id. "</span></div><div style='clear:both;'></div>";
}
}


?>