<?php
  // Extension Configuration
  //
  $plugin_slug = basename(dirname(__FILE__));
  $menu_slug = 'readygraph-app';
  $main_plugin_title = 'Simple Subscribe';
	add_action( 'wp_ajax_nopriv_myajax-submit', 'myajax_submit' );
	add_action( 'wp_ajax_myajax-submit', 'myajax_submit' );
	
function myajax_submit() {
	global $wpdb;
	$subscriber = "subscriber";
	$subscriber_table = $wpdb->prefix . "subscribers";
	$email = mysql_real_escape_string(trim($_POST['email']));
	$fname = mysql_real_escape_string(trim($_POST['fname']));
	$lname = mysql_real_escape_string(trim($_POST['lname']));
	$ip = $_SERVER['REMOTE_ADDR'];
	$sqlcheck = "select * from $subscriber_table where email='$email'";
	update_option('simple_subscribe_data2',$sqlcheck);
	$check = $wpdb->get_results($sqlcheck);
	if ($wpdb->num_rows != 0)
	{
	}
	else{
	$sql = "insert into $subscriber_table set active='0', email='$email', ip='$ip', firstName='$fname', lastName='$lname';";
	update_option('simple_subscribe_data2',$sql);
	$wpdb->get_results($sql);
	}
	wp_die();
	
}  
  // Email Subscription Configuration
  //
  //$url = S2URL;
  //$app_id = get_option('readygraph_application_id', '');
  /*$readygraph_email_subscribe = <<<EOF
  function subscribe(email, first_name, last_name) {
    function submitPostRequest(url, parameters) 
    {
      http_req = false;
      if (window.XMLHttpRequest) 
      {
        http_req = new XMLHttpRequest();
        if (http_req.overrideMimeType) http_req.overrideMimeType('text/html');
      } 
      else if (window.ActiveXObject) 
      {
        try { http_req = new ActiveXObject("Msxml2.XMLHTTP"); } 
        catch (e) {
          try { http_req = new ActiveXObject("Microsoft.XMLHTTP"); } 
          catch (e) { }
        }
      }
      if (!http_req) return;
      http_req.onreadystatechange = eemail_submitresult;
      http_req.open('POST', url, true);
      http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_req.send(parameters);
    }
    
    var rg_url = 'https://readygraph.com/api/v1/wordpress-enduser/';
    var str = "email=" + encodeURI(email) + "&app_id=$app_id";
		if ('$app_id') submitPostRequest(rg_url, str);
    
    str= "txt_email_newsletter="+ encodeURI(email) + "&action=" + encodeURI(Math.random());
    submitPostRequest('$url/eemail_subscribe.php', str);
  }
EOF;
*/
  // RwadyGraph Engine Hooker
  //
  include_once('extension/readygraph/extension.php');
  function readygraph_menu_page() {
	global $wpdb;
    include_once('extension/readygraph/admin.php');

  } 
  function on_plugin_activated_readygraph_ss_redirect(){
	global $menu_slug;
    $setting_url="admin.php?page=$menu_slug";    
    if (get_option('rg_ss_plugin_do_activation_redirect', false)) {  
      delete_option('rg_ss_plugin_do_activation_redirect'); 
      wp_redirect(admin_url($setting_url)); 
    }  
  }
  
 // remove_action('admin_init', 'on_plugin_activated_redirect');
  
//  add_action('admin_menu', 'add_readygraph_admin_menu_option');
  add_action('admin_notices', 'add_readygraph_plugin_warning');
  add_action('wp_head', 'readygraph_client_script_head');
  add_action('admin_init', 'on_plugin_activated_readygraph_ss_redirect');
  	add_option('readygraph_connect_notice','true');
function readygraph_cron_intervals( $schedules ) {
   $schedules['weekly'] = array( // Provide the programmatic name to be used in code
      'interval' => 604800, // Intervals are listed in seconds
      'display' => __('Every week Seconds') // Easy to read display name
   );
   return $schedules; // Do not forget to give back the list of schedules!
}


add_action( 'rg_cron_hook', 'rg_cron_exec' );
$send_blog_updates = get_option('readygraph_send_blog_updates');
if ($send_blog_updates == 'true'){
if( !wp_next_scheduled( 'rg_cron_hook' && $send_blog_updates == 'true')) {
   wp_schedule_event( time(), 'weekly', 'rg_cron_hook' );
}
}
else
{
//do nothing
}
if ($send_blog_updates == 'false'){
wp_clear_scheduled_hook( 'rg_cron_hook' );
}
function rg_cron_exec() {
//	$send_blog_updates = get_option('readygraph_send_blog_updates');
	$readygraph_email = get_option('readygraph_email', '');
//	wp_mail($readygraph_email, 'Automatic email', 'Hello, this is an automatically scheduled email from WordPress.');
	global $wpdb;
   	$query = "SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_modified DESC LIMIT 5";
	
	global $wpdb;
	$recentposts = $wpdb->get_results($query);
	
	echo "<h2> Recently Updated</h2>";
	echo "<ul>";
	$postdata = "";
	$postdatalinks = "";
	foreach($recentposts as $post) {
		$postdata .= $post->post_title . ", "; 
		$postdatalinks .= get_permalink($post->ID) . ", ";
	$url = 'http://readygraph.com/api/v1/post.json/';
	$response = wp_remote_post($url, array( 'body' => array('is_wordpress'=>1, 'message' => rtrim($postdata, ", "), 'message_link' => rtrim($postdatalinks, ", "),'client_key' => get_option('readygraph_application_id'), 'email' => get_option('readygraph_email'))));

	if ( is_wp_error( $response ) ) {
	$error_message = $response->get_error_message();
	echo "Something went wrong: $error_message";
	} 	else {
	echo 'Response:<pre>';
	print_r( $response );
	echo '</pre>';
	}
	echo "</ul>";

	//endif;	
   
}
}

?>