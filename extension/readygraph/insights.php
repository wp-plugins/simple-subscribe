<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   ReadyGraph
 * @author    dan@readygraph.com
 * @license   GPL-2.0+
 * @link      http://www.readygraph.com
 * @copyright 2014 Your Name or Company Name
 */
include("header.php"); 


	if (!get_option('readygraph_access_token') || strlen(get_option('readygraph_access_token')) <= 0) {
	}
	else {
	if (isset($_POST["readygraph_access_token"])) update_option('readygraph_access_token', $_POST["readygraph_access_token"]);
	if (isset($_POST["readygraph_refresh_token"])) update_option('readygraph_refresh_token', $_POST["readygraph_refresh_token"]);
	if (isset($_POST["readygraph_email"])) update_option('readygraph_email', $_POST["readygraph_email"]);
	if (isset($_POST["readygraph_application_id"])) update_option('readygraph_application_id', $_POST["readygraph_application_id"]);
	}
?>	

<form method="post" id="myForm">
<input type="hidden" name="readygraph_access_token" value="<?php echo get_option('readygraph_access_token', '') ?>">
<input type="hidden" name="readygraph_refresh_token" value="<?php echo get_option('readygraph_refresh_token', '') ?>">
<input type="hidden" name="readygraph_email" value="<?php echo get_option('readygraph_email', '') ?>">
<input type="hidden" name="readygraph_application_id" value="<?php echo get_option('readygraph_application_id', '') ?>">
<input type="hidden" name="readygraph_settings" value="<?php echo htmlentities(str_replace("\\\"", "\"", get_option('readygraph_settings', '{}'))) ?>">
<input type="hidden" name="readygraph_delay" value="<?php echo get_option('readygraph_delay', '5000') ?>">
<input type="hidden" name="readygraph_enable_sidebar" value="<?php echo get_option('readygraph_enable_sidebar', 'false') ?>">
<input type="hidden" name="readygraph_enable_notification" value="<?php echo get_option('readygraph_enable_notification', 'true') ?>">
<input type="hidden" name="readygraph_auto_select_all" value="<?php echo get_option('readygraph_auto_select_all', 'true') ?>">
<input type="hidden" name="readygraph_enable_branding" value="<?php echo get_option('readygraph_enable_branding', 'false') ?>">
<input type="hidden" name="readygraph_send_blog_updates" value="<?php echo get_option('readygraph_send_blog_updates', 'true') ?>">
<input type="hidden" name="readygraph_send_real_time_post_updates" value="<?php echo get_option('readygraph_send_real_time_post_updates', 'false') ?>">
<input type="hidden" name="readygraph_popup_template" value="<?php echo get_option('readygraph_popup_template', 'default-template') ?>">

	<div style="margin: 3% 5%">
		<table cellpadding="0" cellspacing="0" border="0" class="table table-hover"  id="ResultTable">
        <thead >
          <tr>
            <th ></th>
            <th >Name</th>
            <th style="text-align: center; ">Email</th>
            <th style="text-align: center; ">Subscribed</th>
          </tr>
          </thead>
          <tbody id="allResultTable">

        </tbody>
      </table>
			
	</div>

</form>
<script>
function drawTable(tbody, jsData) {
    var tr, td;
    tbody = document.getElementById(tbody);
    // loop through data source
    for (var i = 0; i < jsData.length; i++) {
        tr = tbody.insertRow(tbody.rows.length);
        td = tr.insertCell(tr.cells.length);
        td.setAttribute("align", "center");
        td.innerHTML = jsData[i].profile;
		
        td = tr.insertCell(tr.cells.length);
		td.setAttribute("align", "center");
        td.innerHTML = jsData[i].name;
		
        td = tr.insertCell(tr.cells.length);
		td.setAttribute("align", "center");
        td.innerHTML = jsData[i].email;
		
        td = tr.insertCell(tr.cells.length);
		td.setAttribute("align", "center");
        td.innerHTML = jsData[i].subscribed;
    }
}
// drawTable('allResultTable', jsData);
</script>
<?php include("footer.php"); ?>