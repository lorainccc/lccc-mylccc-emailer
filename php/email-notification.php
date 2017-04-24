<?php


 // Send email when post is published.

class lc_email_notify {

 public function __construct(){

   // change mail type to HTML
  function lc_change_mail_type(){
   return 'text/html';
  }
  add_filter( 'wp_mail_content_type', 'lc_change_mail_type' );

  // change to our office365 user account so we can send email
  function lc_change_from_email(){
   return 'wp-notify@lorainccc.edu';
  }
  add_filter( 'wp_mail_from', 'lc_change_from_email' );

  // change from name to LCCC
  function lc_change_from_name(){
   return 'Word Press AWS Notifications';
  }

  add_filter( 'wp_mail_from_name', 'lc_change_from_name' );

  //add_action( 'plugins_loaded', array( $this, 'lc_send_email' ) );
 function lc_send_email($post_id){
  //if( 'mylccc_email' == $post->post_type ){
   //$post_date = esc_attr( get_post_meta( $post_id, 'lc_emailer_post_date', true ) );

   $message = 'Lorain County Community College!';
   wp_mail('jquerin@lorainccc.edu', 'LCCC New for', $message);
   remove_filter( 'wp_mail_content_type', 'lc_change_mail_type' );
  //}

 }
 add_action( 'publish_mylccc_email', array( $this, 'lc_send_email' ), 10, 2 );
}


}

$lc_email_notify_plugin = new lc_email_notify();


?>