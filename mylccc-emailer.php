<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.lorainccc.edu
 * @since             1.0.0
 * @package           Mylccc_Emailer
 *
 * @wordpress-plugin
 * Plugin Name:       MyLCCC Emailer
 * Plugin URI:        http://www.lorainccc.edu
 * Description:       Allows the daily activity email post to be built and scheduled for mailing.
 * Version:           1.0.0
 * Author:            LCCC Web Dev Team
 * Author URI:        http://www.lorainccc.edu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mylccc-emailer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mylccc-emailer-activator.php
 */
function activate_mylccc_emailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer-activator.php';
	Mylccc_Emailer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mylccc-emailer-deactivator.php
 */
function deactivate_mylccc_emailer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer-deactivator.php';
	Mylccc_Emailer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mylccc_emailer' );
register_deactivation_hook( __FILE__, 'deactivate_mylccc_emailer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mylccc-emailer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mylccc_emailer() {

	$plugin = new Mylccc_Emailer();
	$plugin->run();

}
run_mylccc_emailer();

/**
	*	Emailer Custom Post Type
	*
	*	@since 1.0.0
	*/

/* Check if scripts are enqueued or not */
	//if ( wp_script_is( 'jquery-ui-datepicker', 'enqueued' ) ) {
	//	return;
	//} else {
  function lc_emailer_styles(){
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
   }
  add_action( 'wp_enqueue_scripts', 'lc_emailer_styles' );
	//}


 /* Load Plugin logic */

	require_once( plugin_dir_path( __FILE__ ) . 'php/email-post-type.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'php/email-metabox.php' );
// require_once( plugin_dir_path( __FILE__ ) . 'php/email-notification.php' );

  // change mail type to HTML
  function lc_change_mail_type(){
   return 'text/html';
  }
  add_filter( 'wp_mail_content_type', 'lc_change_mail_type' );

  // change from name to LCCC
  function lc_change_from_name(){
   return 'Lorain County Community College';
  }

  add_filter( 'wp_mail_from_name', 'lc_change_from_name' );

function lc_send_email( $post_id ){
  //if( 'mylccc_email' == $post->post_type ){
   //$post_date = esc_attr( get_post_meta( $post_id, 'lc_emailer_post_date', true ) );
   //if( 'publish' == $new_status && 'publish' != $old_status && $post->post_type == 'mylccc_email' ) {
 
 if( wp_is_post_revision( $post_id ) )
  return;
  
  $post = get_post( $post_id );
 
  if( $post->post_status == 'publish' && $post->post_type == 'mylccc_email' ){
 
  $post_title = $post->post_title;
  $post_date = esc_attr( get_post_meta( $post_id, 'lc_emailer_post_date', true ) );
 
  $date = strtotime($post_date);

  $args = array(
   'post_type' 					=> 'lccc_announcement',
   'post_status' 			=> 'publish',
   'posts_per_page' => -1,
   'year'											=> date("Y", $date),
   'month'										=> date("m", $date),
   'day'												=> date("j", $date),
   'orderby'        => 'post_title',
   'order'          => 'ASC',
  );

  $emailer_query = get_posts( $args );

   //The emailer loop for announcements 
  $message = '<link href="https://fonts.googleapis.com/css?family=Lato|Raleway" rel="stylesheet" type="text/css">';
  $message .= "<style>p.headline{font-family:'Raleway';font-size:18pt;}p{font-family:'Lato'; font-size:12pt;}p.subhead{font-family:'Raleway';font-size:16pt; color:#0055a5;}</style>";
 
  $message .= '<div style="width:100%;"><img src="https://www.lorainccc.edu/wp-content/themes/lorainccc/images/LCCC-Logo.png" border="0" width="250"></div>';
  $todays_date = date_create($post_date);
  $todays_date_string = date_format($todays_date, 'l - F d, Y');
  $message .= '<p style="width:100%;"><b>' . $todays_date_string . '</b></p>';
  if( $post->post_content != '' ){
   $message .= '<p>' . $post->post_content . '</p>';
  }
  $message .= '<div style="width:100%;margin:5px 0;"></div>';
  $message .= '<p class="headline">Announcements</p>';
 
   
  if ( $emailer_query ) {
   foreach ( $emailer_query as $post ){
      $message .= '<div class="entry-content">';
      $message .= '		<article>';
      $message .= '			<p class="subhead">' . $post->post_title . '</p>';
      $announcement_date =  date_create(get_post_meta( $post->ID, 'announcement_start_date', true ));
      $announcement_date_string = date_format($announcement_date, 'l - F d, Y');
      $message .= '			<p>' . $announcement_date_string . '</p>';
      $message .= $post->post_content;
      $message .= '	</article>';
      $message .= '</div>';
      $message .= '<hr />';
      
      }
 
   $message .= '<p class="headline">Events Happening Today</p>';
    
   $event_args = array(
   'post_type' 					=> 'lccc_events',
   'post_status' 			=> 'publish',
   'posts_per_page' => -1,
   'meta_query'     => array(
    array(
      'key'     => 'event_start_date',
      'value'   => $post_date,
      'compare' => '=',
    ),
   ),
   'orderby'        => 'post_title',
   'order'          => 'ASC',
  );

  $emailer_query_events = get_posts( $event_args );
   
  if ( $emailer_query_events ) {
   foreach ( $emailer_query_events as $event_post ){
      $message .= '<div class="entry-content">';
      $message .= '		<article>';
 
      $image = get_the_post_thumbnail($event_post->ID, 'thumbnail', array( 'align' => 'left', 'hspace' => '10' ) );
    
      if ( $image != '' ){
       $message .= $image;
      }
    
      $message .= '			<p class="subhead">' . $event_post->post_title . '</p>';

      $event_start_date =  date_create(get_post_meta( $event_post->ID, 'event_start_date', true ));
      $event_start_date_string = date_format($event_start_date, 'l - F d, Y');

      $event_end_date = date_create(get_post_meta( $event_post->ID, 'event_end_date', true ));
      $event_end_date_string = date_format($event_end_date, 'l - F d, Y');
    
      $message .= '			<p>' . $event_start_date_string . ' to ' . $event_end_date_string .'</p>';
      $message .= $event_post->post_content;
      $message .= '	</article>';
      $message .= '</div>';
      $message .= '<hr />';
      }
   

    
   $message .= '<p style="margin-top:35px;"><a href="https://www.lorainccc.edu/mylccc/lccc_events/">View all events</a></p>';
   }
  }

   
   //$subject = 'TEST -- ' . $post_title . ' -- TEST';
   wp_mail('lmartin@lorainccc.edu', $post_title, $message);
   remove_filter( 'wp_mail_content_type', 'lc_change_mail_type' );
   remove_filter( 'wp_mail_from_name', 'lc_change_from_name' );
  }
 }

 add_action( 'save_post', 'lc_send_email' );
 