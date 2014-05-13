
<?php 
global $wpdb;
$app_id = $_GET["app_id"];
if($app_id){
  $sSql = "insert into ".WP_ssubscribe_TABLE_APP." VALUES ('1', '".$app_id."') ";  
  $data = $wpdb->get_results($sSql);
}
?>

<?php 
    $cSql = "select * from ".WP_ssubscribe_TABLE_APP." where 1=1 ";
    $result = $wpdb->get_results($cSql);
    if(count($result) > 0)
    { 
    ?>
    <div class="wrap">
      <div id="icon-plugins" class="icon32"></div>
      <h2>Final Step: Place the widget on your site to get started</h2>
      <h3>Drag the widget to a prominent place to maximize signups.</h3>
      <a class="button add-new-h2" style="text-shadow:none;background:#36812E;background-color:#36812E;color:white;" href="widgets.php">Place Widget Now</a>
      <p>Tips</p>
      <ul>
      <li>-Already have the widget in place? Manage your ReadyGraph account <a href="http://readygraph.com/application/insights/"> here</a></li>
      <li>-Need help? Email <a  href="mailto:nick@readygraph.com">nick@readygraph.com</a> or click <a href="http://readygraph.com">here</a> </li>
      </ul>
      
      
    </div>  


    <?php }else{ ?>

    <div class="wrap">
      <div id="icon-plugins" class="icon32"></div>
      <h2>Simple Subscribe, Now with Readygraph </h2>
      <h3>Activate Readygraph features to optimize Simple Subscribe functionality</h3>
      <p style="display:none;color:red;" id="error"></p>
      <div class="register-left" style="float: left; width:25%;">
      <div class="form-wrap">
          <h3>Free Signup </h3>
          <p>
          <label for="tag-title">Site URL</label>
          <input type="text" id="register-url" name="eemail_on_homepage">
          </p>

          <p>
          <label for="tag-title">Name</label>
          <input type="text" id="register-name" name="eemail_on_homepage">
          </p>

          <p>
          <label for="tag-title">Email</label>
          <input type="text" id="register-email" name="eemail_on_homepage">
          </p>
          <p>
          <label for="tag-title">Password</label>
          <input type="password" id="register-password" name="eemail_on_homepage">
          </p>
          <p>
          <label for="tag-title">Confirm Password</label>
          <input type="password" id="register-password1" name="eemail_on_homepage">
          </p>
          
          <p style="max-width:180px;font-size: 10px;">By signing up, you agree to our <a href="http://www.readygraph.com/tos">Terms of Service</a> and <a href='http://readygraph.com/privacy/'>Privacy Policy</a>.</p>
          <p style="margin-top:10px;">
          <input type="submit" style="text-shadow:none;background:#36812E;width:193px;background-color:#36812E;color:white;" value="Continue to place widget" id="register-app-submit" class="button" name="Submit">
          </p>
      </div>
          
      </div>
      <div class="register-mid" style="float: left;width:25%;">
          <div class="form-wrap">
          <p>
          <h3>Already a member?</h3>
          <label for="tag-title">Email</label>
          <input type="text" id="signin-email" name="eemail_on_homepage">
          </p>
          <p>
          <label for="tag-title">Password</label>
          <input type="password" id="signin-password" name="eemail_on_homepage">
          </p>
          <p style="padding-top:10px;">
          <input type="submit" style="width:193px;color:" value="Sign In" id="signin-submit" class="button add-new-h2" name="Submit">
          </p>
      </div>
      </div>
        <div class="register-right" style="float:left;width:35%;">
          <div class="form-wrap alert" style="font-size: 16px;background-color: #F9F8F3;border: 2px solid #EBECE8;border-radius: 6px;padding: 16px 45px 16px 30px;">
          <p>
          <h3>Signup For These Benefits:</h3>
          <p>-Grow your subscribers faster</p>
          <p>-Engage users with automated email updates</p>
          <p>-Enhanced email deliverablility</p>
          <p>-Track performace with user-activity analytics</p>
          </div>
      </div>
    <?php } ?>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">


$('#signin-submit').click(function(e){
  var email = $('#signin-email').val()
  var password = $('#signin-password').val()
  if(!email){
    alert('email is empty!')
    return
  }
  if(!password){
    alert('password is empty')
    return
  }
    $.ajax({
      type: 'GET',
      url: 'https://readygraph.com/api/v1/wordpress-login/',
      data: {
        'email' : email,
        'password' : password
      },
      dataType: 'json',
      success: function(response) {
        if(response.success)
        {
           
          var pathname = window.location.href;
          window.location = pathname + "&app_id="+response.data.app_id;
        }else{
          $('#error').text(response.error)
          $('#error').show();
        }
      }
  });


});

$('#register-app-submit').click(function(e){
  var email = $('#register-email').val()
  var site_url = $('#register-url').val()
  var first_name = $('#register-name').val()
  var password = $('#register-password').val()
  var password2 = $('#register-password1').val()
  if(!site_url){
    alert('Site Url is empty.')
    return;
  }
  if(!email){
    alert('Email is empty.')
    return;
  }
  if( !password || password != password2 ){
    alert('Password is not matching.')
    return;
  }

  $.ajax({
      type: 'POST',
      url: 'https://readygraph.com/api/v1/wordpress-signup/',
      data: {
        'email' : email,
        'site_url' : site_url,
        'first_name': first_name,
        'password' : password,
        'password2' : password2,
        'source':'simple-subscribe'
      },
      dataType: 'json',
      success: function(response) {
        if(response.success)
        {
          var pathname = window.location.href;
          window.location = pathname + "&app_id="+response.data.app_id;
        }else{
          $('#error').text(response.error)
          $('#error').show();
        }
      }
  });

});
</script>