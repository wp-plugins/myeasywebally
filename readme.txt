=== myEASYwebally ===
Contributors: camaleo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WNNDSCQ5L8N5J
Tags: myeasy, web, webally, ally, update, admin, administration, help, plugin, plugins, wordpress
Requires at least: 2.8
Tested up to: 3.5.*
Stable tag: 1.3.5
License: GPLv2 or later

More than a simple plugins, myEASYwebally will save you a lot of time when doing your WordPress blog maintenance!

== Description ==
How much time do you spend to perform your WordPress blogs/sites maintenance?

Are you sure the new plugins you are going to install will not break your WordPress installation?

Are all your plugins and your template ready for the latest version of WordPress?

When using WordPress to professionally produce sites for your customers, doing the proper maintenance can really take a lot of time.

When WordPress websites are not updated it is pretty common for them to get hacked.

The main problems in keeping everything updated is the amount of extra time you need to take from your already busy schedule and the risk to get your WordPress installation broken by a plugin upgrade.

Now you can enroll your ally and let him help you to save quite a good amount of time, myEASYwebally!

Install myEASYwebally on all your WordPress blogs/sites, enter your own API key in the settings page and click on the activate button: that's it!

To 'group' the information from several sites to the same user, the mechanism uses an API key, available for free by <a href="https://services.myeasywp.com/account-add/">registering</a> at our website.

We are also working on a number of additional services you will be able to get from your ally, check out what's going on <a href="http://myeasywp.com/services/">here</a>.

Based on the preferences you set on the dedicated site, you will start getting a daily, weekly or monthly email report. You may also decide not to receive emails and check the reports on the dedicated server.

Each report includes vital information about all the plugins installed on all your blogs/sites. Moreover it lists all the links related to each plugin as well as some clues about what you should do for each of them.

How does myEASYwebally work?

myEASYwebally is made of two different agents: the plugin and its <a href="http://myeasywp.com/services/">dedicated server</a>.

The plugin takes care of collecting the information you need to know about your WordPress installations at regular intervals of time. Such information is saved on your uploads folder as a PHP page. This page is created in a way that it shows the included information ONLY when its called from the dedicated server.

The dedicated server checks the pages created by myEASYwebally at regular intervals of time and to keep a list of all the reported plugins, their related information as well as some useful information about your WordPress installation. Periodically, the dedicated server reads the information from its database to prepare and email a report with those informations to you.

Related Links:

* <a href="https://services.myeasywp.com" title="Improve Your Life, Go The myEASY Way">Register your free account at services.myeasywp.com</a>
* <a href="http://myeasywp.com/" title="myEASYwp: WordPress plugins created to make your life easier">myEASYwp plugin series homepage</a>
* myEASYwebally is the perfect companion to <a href="http://myeasywp.com/plugins/myeasyhider/" target="_blank">myEASYhider</a> and <a href="http://myeasywp.com/plugins/myeasybackup/" target="_blank">myEASYbackup</a>, two other plugins in the myEASY serie.
* For the latest news about the myEASY plugin serie follow me on <a href="http://twitter.com/camaleo" target="_blank" title="myEASY plugins news">Twitter</a>


== Installation ==
1. Upload the full directory into your `wp-content/plugins` directory
1. Pending on your server setting you may need to manually copy one file from the plugins directory to your main WordPress installation directory; the plugin will let you know what to copy and where if it will not be able to do it itself
1. Activate the plugin through the 'Plugins' menu in the WordPress Administration page. Note: to be able to activate the the plugin you need to enter your own API key; you can create your free API key at http://services.myeasywp.com/account-add/
1. Let the plugin work for you: every day, the first visitor to your blog/site will automatically trigger the update of the notification file.


== Frequently Asked Questions ==
= If I need help with this plugin, where can I get support? =

For an updated list of FAQ, please check:
http://myeasywp.com/faq/

If you cannot find an answer there please submit your request at:
https://myeasywp.zendesk.com/


== Screenshots ==
To save your bandwidth, we better like to show you the screen shots at the <a href="http://myeasywp.com/plugins/myeasywebally/">official plugin page</a>.


== Changelog ==
= 1.3.5 (17 December 2012) =
Fully WordPress 3.5.* compatible.

= 1.3.4 (14 June 2012) =
Fully WordPress 3.4.* compatible.

Fixed:
* The plugin can be successfully activated also on servers with URL file-access disabled.
* Under some circumstances the notifier file was not properly written, preventing the mechanism to work.

= 1.3.1 (25 May 2012) =
Removed the updates notification system as the plugin is available again at wordpress.org
For info about why it was removed, please see: http://myeasywp.com/protect-your-rights/

= 1.2 (15 May 2012) =
Added the updates notification system.

= 1.1.0 (13 May 2012) =
Update the plugin options after installing this version.

Fixed:

* Replaced a special char that went wrong due to file codification.

Changed:

* Updated the notifier for compatibility with the latest server.

= 1.0.8.1 (24 July 2011) =
Replaced few lines of a Creative Commons licensed code used to handle the mailing list subscription as per kind request from wordpress.org

= 1.0.8 (23 July 2011) =
All the images and javascript code is now loaded from the same server where the plugin is installed.
Last year I tought it might be useful to have the myeasy common images and code loaded from a CDN to avoid having to update all the plugins in the series each time an image changes and to load pages faster; so I moved all the common items to a CDN.
Today I received a kind email from wordpress.org letting me know that "there a potential malicious intent issue here as you {me} could change the files to embed malicious code and nobody would be the wiser" and asking me to change the code.
I promptly reacted to show everyone that I am 101% in bona fide and here is a new version.

= 1.0.4 (27 November 2010) =
Fixed:

* The authorized ip of the main server is now automatically calculated - please allow 24 hours for this change to be taken into effect after you install this update.
* Once the plugin is activated it will be immediately recognized by the services site. Before this fix you needed to reload the blog home page to be able to add the blog on the services site.

= 1.0.3 (13 November 2010) =
Fixed:

* Removed unnecessary calls to style sheet and javascript.
* Fixed an issue where in certain circumstances the file including the generated info was missing some data.

Changed:

* Changed the <a href="http://eepurl.com/bt8f1" target="_blank">newsletter provider</a> as the previous one is going to close his service by the end of 2010.

= 1.0.1 (2 September 2010) =
Fixed:

* Changed the option name used to show/hide the plugin credits to avoid duplicates when using more than one plugin in the myEASY series.

= 1.0.0 =
This is the first release.


== Upgrade Notice ==

= 1.1.0 =
Update the plugin options after installing this version.

= 1.0.4.1 =
Fully deactivate and then reactivate after installing this version.

= 1.0.0 =
This is the first release.
