<?php


 // Send email when post is published.

 function lc_send_email($post_id){
  if( 'publish' != get_post_status($post_id) && 'mylccc_email' == get_post_type() ){
   echo '<center><h1>hello</h1></center>';
   $post_date = esc_attr( get_post_meta( $post_id, 'lc_emailer_post_date', true ) );
   $message = 'Hello!';
   wp_mail('jquerin@lorainccc.edu', 'Test Email', $message);
  }
 }

 //add_action( 'save_post', 'lc_send_email', 10, 2 );

   echo '<center><h1>hello</h1></center>';



/*class lc_email_notify {

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

   add_action( 'plugins_loaded', array( $this, 'lc_test_notify' ) );
  }

  function lc_test_notify(){
   $message = 'Hello!';
   $sent_message = wp_mail('jquerin@lorainccc.edu', 'Test Email', $message);
   
   if($sent_message){
    echo 'message sent';
   } else{
    echo 'sent failure';
   }
   
   }

}

$lc_email_notify_plugin = new lc_email_notify();*/


?>