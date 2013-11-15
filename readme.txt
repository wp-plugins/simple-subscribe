=== Simple Subscribe ===
Contributors: latorante
Donate link: http://donate.latorante.name/
Tags: subscription, e-mail subscription, simple subscription, digest, post news, post e-mails
Requires at least: 3.3
Tested up to: 3.7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.0

Simple Subscribe is the subscribe plugin you have been waiting for. It's simple to use, yet powerful, bulletproof and developers friendly.

== Description ==

Simple Subscribe is the only bulletproof secure plugin, that is easy to use and developers friendly as well. It gives you the power to simply add subscription
form to your Wordpress website, as a **widget**, **shortcode** or using php in your template codes.

Subscription form can gather more than just e-mail address tho, you can select additional fields like name, location, age and interests. All the subscribers can
be exported into **.csv**, **.xls**, **.tsv** or **.xml** format and used anywhere else, in fact, you can even select to export by criteria **active**, or **inactive** or simply **all**.

Your subscribers have the option to unsubscribe in each e-mail digest they receive, or you can put unsubscription form on your website. As of now, all use HTML template,
and the new post digest uses short excerpt, with post title and post featured image (if there is any). In future I plan to add different e-mail template options (see below in road-map).
Your digest email can contain your favourite social media links, just set them up simply in the admin, and they appear automatically in the e-mail. You can even try
sending a post digest only to yourself, so you can see what it looks like, the option is Admin > Subscribers > Settings, on the right hand side.

All Wordpress registered users have the option to subscribe simply in their Wordpress profile, by checking *E-mail subscriptions* in **Personal Options** section.

Forms have both client / server side validation and they are literally bulletproof. There plenty of other features you will find "on the run".

= Road-map =

This is what I plan to implement in upcoming versions of **Simple Subscribe:**

* Plugin "messages" settings
	* Confirm subscription message
	* Unsubscription message
	* Thank you message and all others
* Allow language support and translations
* Email "digest type" settings
	* Short Excerpt (plain text)
	* Short Excerpt (html)
	* Short Excerpt with featured image (html - current only option)
	* Full post (html)
* Subscribe - select digest category
* Subscribe - select digest post type (post / page ... others)
* Subscribers import ( xml / csv / tsv *(maybe xls?)*)
* Subscribers import maybe from other places / plugins?
* E-mail queque, se we won't overkill the server with thousands of subscribers.
* Email template editor, styles, colours, custom header image, etc.
* Ability to edit subscribers

== Installation ==

= Automatic =
1. Go to your admin area and select Plugins -> Add new from the menu.
2. Search for "Simple Subscribe".
3. Click install.
4. Click activate.
5. Enjoy.

= Manual =
1. Go to [http://Wordpress.org/plugins/simple-subscribe/](http://Wordpress.org/plugins/simple-subscribe/ "Simple Subscribe")
2. Download latest version of Simple Subscribe.
3. Unzip file into Wordpress plugins directory.
4. Activate plugin.
5. Enjoy.

== Screenshots ==

1. Simple Subscribe Settings Page.
2. Listing of subscribers with export options, and form to add new subscriber thru admin.
3. Wordpress registered users settings in their profile.
4. Subscribe Widget
5. Subscribe Widget Invalid Form Values
6. Subscribe Widget Invalid Form Values II
7. Subscribe Widget Valid

== Developer's Guide ==

= Intro =

Apart from being able to use **widgets** and **shortcodes** in your Wordpress installation to display subscription and unsubscription forms, as a developer,
you sometimes need more methods of controlling your content and theme behaviour. But before we jump on php examples, I'm gonna list styling used by this plugin
so you can amend the look of forms and messages in the front end. There's a stylsheet with some styling for these form included in front-end of the website,
if you wish to not load my stlyes, just turn them off in **Subscribers > Settings**. So here goes the styles:

`
/* General */
span.error {} // error message
span.success {} // success message

/* Widgets */
.widgetGuts {} // widget insides
.widgetGuts dt {} // odd / even rows
.widgetGuts dd {}
.widgetGuts dt label { } // label field
.widgetGuts dt label.required { } // required label field
.widgetGuts dd input { } // input fields
.widgetGuts dd textarea { } // input fields
.widgetGuts dd input.button { } // submit button

/* Shortcodes */
.shortcode,
.widgetGuts.shortcode {} // either one of them, guts of shortcode
.shortcode h3 {} // form title
.shortcode table {} // form table
.shortcode table tr {} // table row
.shortcode table tr.required {} // required
.shortcode table tr th {} // holds label
.shortcode table tr td {} // holds input / textarea
.shortcode table tr th label {} // label
.shortcode table tr td input,
.shortcode table tr td textarea {} // input fields
.shortcode table tr td input.button {} // submit button
`

Now when styles are out of the way, let's look at those dev examples.

= Examples =

Let's check what we can do, we're gonna be using class called `SimpleSubscribeDevelopers`. To retrieve an
object of our form we simply call:

`
<?php
	// get sebuscription form
	$subscriptionForm = SimpleSubscribeDevelopers::getSubscriptionForm();

	// or unsubscription one, whichever one you need
	$unsubscriptionForm = SimpleSubscribeDevelopers::getUnsubscriptionForm();
?>
`

With the form object we can do wonders, consider this code:

`
<?php
	// get form object
	$subscriptionForm = SimpleSubscribeDevelopers::getSubscriptionForm();

	// check if form was submitted
	if($subscriptionForm->isSubmitted()){
		// form was submitted
	}

	// check if form was submitted and was valid = that means, there were no errors
	// and subscriber was successfully added / or unsubscribed (depends on which form we have in our object)
    if($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()){
    	// form was submitted - and valid, saved in db show your messages.
	}


	// check if form was submitted and had erros, those can be non-valid fields,
	// subscriber with same address already in system, etc.
	if($subscriptionForm->isSubmitted() && $subscriptionForm->hasErrors()){
		// dump erorrs
		dump($subscriptionForm->getAllErrors());
		// Note: method $subscriptionForm->getAllErrors() retrieves all errors, you can list them using foreach
		// or save them, do whatever you wish to do.
    }

    // display form
	echo $subscriptionForm;

`

= Advanced Example =

That is some funky stuff isn't it. Let's create a life like example for ourselves, one used in everyday situations. Imagine that we have a website
with for example a modal window, with a nice subscription form. That modal window is a hidden element that appears if some clicks on button called
"Subscribe". The form shows up in a modal window, everything is great, but what happens when you send the form? Since we don't use ajax calls to submit the form,
it's going to refresh the whole page thus making the modal window element hidden again with keen information about form being successfully sent or not.
Now that is excactly the case where we use `SimpleSubscribeDevelopers` class instead of shortcodes and widgets, and help ourselves to control that situation.
Consider this code:

`
	<?php
		// get our subscription form
		$subscriptionForm = SimpleSubscribeDevelopers::getSubscriptionForm();
		// with this we determine modal windows class, since it's hidden automatically,
		// with every submission, we should make it visible, therefore add class "visible"
		$modalWindowVisible = $subscriptionForm->isSubmitted() ? 'visible' : '';
		// just empty variable to be filled with errors / success message
		$subscriptionMessage = '';
		// is it valid or not?
		if($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()){
			// it is, this is our messages
			$subscriptionMessage = 'You have succesfully subscribed, e-mail is on it\'s way!';
		} elseif($subscriptionForm->isSubmitted() && $subscriptionForm->hasErrors()) {
			// it's not! get error messages in variable
			$subscriptionMessage = print_r($subscriptionForm->getAllErrors(), TRUE);
		}
	?>
	<style type="text/css">
		.modalWindow { display: none; }
		.modalWindow.visible { display: block; }
	</style>
	<div id="modalWindow" class="modalWindow <?php echo $modalWindowVisible; ?>">
		<?php
			// print message, if any
			echo $subscriptionMessage;
			// display form
			echo $subscriptionForm;
		?>
	</div>
	<button onclick="displayModal()">Show Modal</button>
	<script type="text/javascript">
		function displayModal(){
			document.getElementById("modalWindow").className = "visible";
		}
	</script>
`

Right, let's go thru this code again, it's pretty straightforward. At first, we create an instance of our form, we check if it was submitted, if it was - no matter
if correctly or not, we should always display our hidden modal window, so people can see it straight away after the page reloads - we set the modal window class to "visible".

After that it's simple code, just to show working example of that logic, you can copy and paste this code or change, amend, whatever you wish to do.

== Changelog ==

= 1.0 =
* Added option for Wordpress registered users to use subscription.
* Added Additional form fields that can be set from Admin (First Name, Last Name, Age, Interests, Location).
* Added .XML export.
* Added .XLS export.
* Added .CSV export.
* Added .TSV export.
* Added Subscribe Widget
* Added Unsubscribe Widget
* Added Subscribe Shortcode [simpleSubscribeForm]
* Added Unsubscribe Shortcode [simpleUnsubscribeForm]
* First concept version.