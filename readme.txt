=== Simple Subscribe ===
Contributors: Dabelon, wenzhixue, latorante
Donate link: http://donate.latorante.name/
Tags: subscription, subscribe, e-mail subscript ion, email subscription, simple subscription, digest, post news, post e-mails, e-mail newsletter, newsletter
Requires at least: 3.3
Tested up to: 3.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.3

Simple Subscribe is the subscribe plugin you have been waiting for. It's simple to use, yet powerful, bulletproof and developers friendly.

== Description ==

Simple Subscribe is the only bulletproof secure plugin, that is easy to use and developers friendly as well. It gives you the power to simply add subscription
form to your Wordpress website, as a **widget**, **shortcode** or using php in your template codes.

Subscription form can gather more than just e-mail address, you can select additional fields like name, location, age and interests. All the subscribers can
be exported into **.csv**, **.xls**, **.tsv** or **.xml** format and used anywhere else, in fact, you can even select to export by criteria **active**, or **inactive** or simply **all**.

Your subscribers have the option to unsubscribe in each e-mail digest they receive, or you can put unsubscription form on your website. As of now, all use HTML template,
and the new post digest uses short excerpt, with post title and post featured image (if there is any). In future I plan to add different e-mail template options (see below in road-map).
Your digest email can contain your favourite social media links, just set them up simply in the admin, and they appear automatically in the e-mail. You can even try
sending a post digest only to yourself, so you can see what it looks like, the option is Admin > Subscribers > Settings, on the right hand side.

All Wordpress registered users have the option to subscribe simply in their Wordpress profile, by checking *E-mail subscriptions* in **Personal Options** section.

Forms have both client / server side validation and they are literally bulletproof. There plenty of other features you will find "on the run".

**New** you can change the look of the e-mail digest, colours, type etc. and contact all your subscribers directly with your own Subject and Message right from your Wordpress dashboard.

If you are a **Developer**, what you're looking for is [here.](http://wordpress.org/plugins/simple-subscribe/other_notes/ "Developer's Guide")

= ReadyGraph App =

This menu item allows users to sign up for a free ReadyGraph account, or sync an existing free ReadyGraph account.  Once a ReadyGraph account is synced, this menu item is where the user manages their ReadyGraph account, views email addresses, sends emails to their community members, and views insights on user growth.		

= Requirements =

1. Wordpress at least version 3.3
1. PHP at least version 5.3.1
1. Working e-mail functions on your server

== Installation ==

= Automatic =
1. Go to your admin area and select Plugins -> Add new from the menu.
2. Search for "Simple Subscribe".
3. Click install.
4. Click activate.
5. Enjoy.

= Manual =
1. Go to [http://wordpress.org/plugins/simple-subscribe/](http://wordpress.org/plugins/simple-subscribe/ "Simple Subscribe")
2. Download latest version of Simple Subscribe.
3. Unzip file into Wordpress plugins directory or install zip via upload in admin plugins page.
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
8. E-mail template options
9. Log messages
10. Mass e-mail message

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

Let's check what we can do, we're gonna be using class called `Developers`. To retrieve an
object of our form we simply call:

`
<?php
	// get subscription form
	$subscriptionForm = \SimpleSubscribe\Developers::getSubscriptionForm();

	// or unsubscription one, whichever one you need
	$unsubscriptionForm = \SimpleSubscribe\Developers::getUnsubscriptionForm();
?>
`

With the form object we can do wonders, consider this code:

`
<?php
	// get form object
	$subscriptionForm = \SimpleSubscribe\Developers::getSubscriptionForm();

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
Now that is excactly the case where we use `Developers` class instead of shortcodes and widgets, and help ourselves to control that situation.
Consider this code:

`
	<?php
		// get our subscription form
		$subscriptionForm = \SimpleSubscribe\Developers::getSubscriptionForm();
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

Right, let's go through this code again, it's pretty straightforward. At first, we create an instance of our form, we check if it was submitted, if it was - no matter
if correctly or not, we should always display our hidden modal window, so people can see it straight away after the page reloads - we set the modal window class to "visible".

After that it's simple code, just to show working example of that logic, you can copy and paste this code or change, amend, whatever you wish to do.

== Frequently Asked Questions ==

= It requires PHP 5.3 and I don't have that =
Well this one is a no-go unfortunately. Just upgrade, or change provider or use a differnt plugin ;).

= It doesn't work they way I wanted it to =
Yes, in that case just deactivate and unstinall the plugin.

== Upgrade Notice ==

= 1.3 =
* Integrated ReadyGraph functionality.

= 1.2.3 =
* Change e-mail body background colour, e-mail digest links as text for html stripping e-mail clients.

= 1.2 =
* Added post digest categories and other small features.

= 1.1.5 =
* Newer, better.

= 1.1.4.5 =
* Hopefully last of the small updates, fixing activation / deactivation hooks and uninstall

= 1.1.4.4 =
* Empty subject bug-fix fallback.

= 1.1.4.3 =
* Older PHP failsafe message - preventing PHP error failure on installations with PHP lower than 5.3.1

= 1.1.4.2 =
* Better e-mail handeling. (memorywise)

= 1.1.4.1 =
* (Bug)fix, now using Bcc instead of Cc for mass emails.

= 1.1.4 =
New features, contact subscribers directly with one click in subscribers listing.

= 1.1 =
Wordpress registered users better handeling.

= 1.0.8.1 =
Minor bug fix, user profile subscription meta.

= 1.0.8 =
More options for setting up e-mail template and sender info.

== Changelog ==

= 1.3 =
* Integrated ReadyGraph functionality.

= 1.2.3.1 =
* Christmas bugfix, settings not being injected in API call. Merry happy!

= 1.2.3 =
* Subscription confirmation url in text format as well, for e-mail clients that strip HTML links
* Added option to select backlink url on Confrimation screen, (if a static page is selected as posts page)
* Added option to change e-mail background colour

= 1.2 =
* You can select post digest Category now
* Better log message handeling - you can delete individual messages, instead of just clearing all.
* Better admin css for mobile devices
* Ability to change screen options and number of displayed subscribers on page.
* Added Google+, Tumblr and Flickr to social links in e-mail template.
* Other tiny features

= 1.1.5 =
* Modified theme for new Wordpress 3.8 admin, and Twenty Fourteen
* Added Widget settings (Title) *(thanks to Elaine)*
* Fixed small typos *(thanks to Elaine)*
* Removed email "To:" parameter, all e-mails now go thru Bcc only *(thanks to Anders)*
* Longer excerpt, using Wordpress Excerpt if there is, or making custom one from post content if there isn't *(thanks to Elaine)*
* New settings added, choose your post digest "Subject" *(thanks to Victoria)*
* Fixed Subscription confirmation e-mail link - underlined now.

= 1.1.4.5 =
* Hopefully last of the small updates, fixing activation / deactivation hooks and uninstall. I'm so sorry guys!

= 1.1.4.4 =
* Empty subject bug-fix fallback.

= 1.1.4.3 =
* Older PHP failsafe message - preventing PHP error failure on installations with PHP lower than 5.3.1

= 1.1.4.2 =
* Better e-mail handeling. (memorywise)

= 1.1.4.1 =
* (Bug)fix, now using Bcc instead of Cc for mass emails.

= 1.1.4 =
* Newly you can e-mail subscribers directly, either using admin form, or clicking "E-mail directly" in subscribers listing
* Mass e-mail All Subscribers / All Wordpress Registered / All Non-wordpress Registered / Single subscriber with your news!
* Slightly changed admin styles.

= 1.1 =
* Added an otpion to add Wordpress Registered users to subscription list *(This one is for you Carl!)*
* Wordpress registered users get the option to unsubscribe from their profile - might have caused problems when using unsubsription form on website with Wordpress registered user's e-mail.
* Changed codebase, better code handeling, autoloading - faster excecution
* Added **Message Log** - by default it's on, you can turn off - but, it hodls ipmortant messages about cron jobs, possible server failure of e-mail sending, and in future e-mail queue.
* Few other small bits, not really visible (in code)

= 1.0.8.1 =
* Minor bugfix, user profile meta.

= 1.0.8 =
* Added option to deactivate wordpress registered users from subscription
* E-mail template settings on it's own page
* Added option to choose what happends, after user unsubscription (delete user, or deactivate?)
* Added theming options of e-mail template (header background colour, title colour, links colour)
* Added e-mail type (html / plain text)
* Added e-mail digest type (Short Excerpt / Short Excerpt with Featured Image / Whole Post)
* Added option for setting up custom blog name / email
* Small speed enhancements

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