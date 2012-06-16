<?php

/* Version: 1.3.4 */

class myEASYwebally_CLASS {

	/**
	 * main class for the myEASYwebally plugin
	 */
	var $version = MYEWALLY_VERSION;
	var $plugin_name = 'myEASYwebally';
	var $folder_name = MYEWALLY_FOLDER;
	var $plugin_slug = 'myeasy-webally';
//	var $plugin_notifier = 'myeasywebally';

	var $css;               // name of the css file
	var $js;                // name of the javascript file
	var $url;               // url to the plugin main folder
	var $locale;            // locale to be used for the translations
	var $help;              // help text to be shown in the contextual page
	var $dash_title;        // title of the plugin item in the dashboard
	var $dash_contents;     // contents of the plugin item in the dashboard
	var $main_plugin;       // main plugin file

	function plugin_init() {

		/**
		 * initializations
		 */
		wp_register_style('myeasywp_common', MYEASY_CDN_CSS.'myeasywp.css');   // common myeasy style

		register_deactivation_hook($this->main_plugin, array($this, 'plugin_deactivate'));
//echo $this->main_plugin;

		if(strlen($this->css)>0) {
			wp_register_style($this->plugin_slug . '-style', $this->url . '/css/'.$this->css.'.css');
		}
		if(strlen($this->js)>0) {
			wp_register_script($this->plugin_slug . '-script', $this->url . '/js/'.$this->js.'.js');
		}
		if(strlen($this->locale)>0) {
			load_plugin_textdomain($this->locale, dirname(__FILE__), dirname(__FILE__) . '/langs/');
		}
	}

	function plugin_deactivate() {

		/**
		 * everything you need to do when deactivating the plugin
		 */
//		if(file_exists(MYEWALLY_REPORT_FILE))
//		{
//			@unlink(MYEWALLY_REPORT_FILE);
//		}
//
//		delete_option( 'myewally_userKey' );
//		delete_option( 'myewally_userEmail' );
//		delete_option( 'myewally_emailfrq' );
//		delete_option( 'myewally_last_update' );
	}

	function plugin_setup() {

		/**
		 * setting up css & js
		 */
//echo '(<b>plugin_setup</b>:'. $this->plugin_name.')';

		$time = time();
		wp_enqueue_style( 'myeasywp_common', MYEASY_CDN_CSS.'myeasywp.css', '', $time, 'screen' );
		wp_enqueue_script( 'myeasywp_common', MYEASY_CDN_JS.'myeasywp.js', '', $time, false );

		if(strlen($this->css)>0) {

			wp_enqueue_style($this->plugin_slug . '-style', $this->url . '/css/'.$this->css.'.css', '', $this->version, 'screen');
		}
		if(strlen($this->js)>0) {

			wp_enqueue_script($this->plugin_slug . '-script', $this->url . '/js/'.$this->js.'.js', '', $this->version, false);
		}

		/**
		 * updates notifier
		 */
		$updates = '';


		/**
		 * adding the plugin entry in the settings menu
		 */
		$plugin_page = add_options_page(

			$this->plugin_name,						// page title
			$this->plugin_name . $updates,			// menu title
			'administrator',						// access level
			$this->plugin_name.'_settings',			// file
//			$this->plugin_name.'_settings_page		// function
			array($this, 'the_settings_page')		// function
		);

		if(function_exists('add_contextual_help') && strlen($this->help)>0) {
			/**
			 * contextual help
			 */
			add_contextual_help($plugin_page, $this->help);
		}

		if(strlen($this->dash_title)>0) {
			/**
			 * dashboard widget
			 */
			add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
		}
	}

	/**
	 * adding a link to the settings page in the plugin list page
	 */
	function register_plugin_settings($pluginfile) {

		add_action('plugin_action_links_' . basename(dirname($pluginfile)) . '/' . basename($pluginfile),
							array($this, 'plugin_settings'), 10, 1);

		add_filter('plugin_row_meta', $this->add_plugin_links, 10, 2);
	}

	function plugin_settings($links) {

		$settings_link = '<a href="options-general.php?page='. $this->plugin_name .'_settings'.'">' . __('Settings') . '</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	function add_plugin_links($links, $file) {

		/**
		 * adding an info link in the plugin list page
		 */
		if($file == plugin_basename(__FILE__)) {
			$links[] = __( 'For further information please visit', MYEWALLY_LOCALE ) . ' <a href="http://services.myeasywp.com">services.myeasywp.com</a>';
		}
		return $links;

	}

	/**
	 * adding the plugin own dashboard widget
	 */
	function add_dashboard_widget() {

		wp_add_dashboard_widget($this->plugin_slug, $this->dash_title, array($this, 'dashboard_widget_function'));

		global $myeasywp_news;
		//echo '{'.$myeasywp_news->ref_code.'}';//debug
		if($myeasywp_news->ref_code=='') {

			$myeasywp_news = new myeasywp_news();
			$myeasywp_news->ref_code = 'mew';
			$myeasywp_news->ref_family = '';
//			$myeasywp_news->ref_family = false;//debug
			$myeasywp_news->plugin_init();
			$myeasywp_news->register_widget();
		}
	}

	function dashboard_widget_function() {

		echo $this->dash_contents;
	}

	function the_settings_page() {

		/*
		 * the plugin settings page
		 */
//		global $wpdb;

//$sql = 'SELECT count(*) as tu FROM `'.$wpdb->users.'` ';
//$rows = $wpdb->get_results( $sql );

		?><script type="text/javascript">var myeasyplugin = 'myeasywebally';</script><?php

		echo '<div class="wrap">'
				.'<div id="icon-options-general" class="icon32" style="background:url(http://myeasywp.com/service/img/icon.png);"><br /></div>'
				.'<h2>myEASYwebally: ' . __( 'Settings' ) . '</h2>'

//.$rows[0]->tu

//			.'</div>'
		;

		$_POST['myewally_userKey'] = trim($_POST['myewally_userKey']);
		$_POST['myewally_userEmail'] = trim($_POST['myewally_userEmail']);


// services: 67.215.65.132
//echo '['.gethostbyname('services.myeasywp.com').']';
//$authorized_ip = file_get_contents('https://services.myeasywp.com/auth-ip/');   // 1.1.0
//echo 'auth-ip['.$authorized_ip.']';


		switch($_POST['btn'])
		{
			#----------------
			case ACTIVATE_BTN:
			#----------------
				#
				#	activate the plugin
				#
				/**
				 * get the authorized ip from the main server
				 */
//				$authorized_ip = file_get_contents('http://myeasywp.com/service/auth-ip.php');  // 1.0.4
//				$authorized_ip = gethostbyname('services.myeasywp.com');                        // 1.0.4
				$authorized_ip = file_get_contents('https://services.myeasywp.com/auth-ip/');   // 1.1.0

				update_option( 'myewally_authorized_ip', $authorized_ip );

				if(isset($_POST['myewally_userKey']))
				{
					update_option( 'myewally_userKey', $_POST['myewally_userKey'] );
				}

				/**
				 * @since 1.0.4 : re-create the report file
				 */
//echo '{{{'.MYEWALLY_REPORT_FILE.'}}}';
//echo '{{{'.MYEWALLY_AUTHORIZED_IP.'}}}';
				define('MYEWALLY_AUTHORIZED_IP', $authorized_ip);
				if(file_exists(MYEWALLY_REPORT_FILE)) {

					@unlink(MYEWALLY_REPORT_FILE);
				}
				$MYEWALLY_frontend = new myEASYwebally_FRONTEND();
				$MYEWALLY_frontend->locale = MYEWALLY_LOCALE;

				break;
				#
			#----------------
			case DEACTIVATE_FULL_BTN:
			#----------------
				#
				#	Full plugin deactivation
				#
				if(file_exists(MYEWALLY_REPORT_FILE))
				{
					@unlink(MYEWALLY_REPORT_FILE);
				}

				if(is_writable(ABSPATH)) {

					@unlink(ABSPATH.'myEASYwebally-notifier.php');
				}

				delete_option( 'myewally_userKey' );
				delete_option( 'myewally_userEmail' );
				delete_option( 'myewally_emailfrq' );
				delete_option( 'myewally_last_update' );
				delete_option( 'myewally_authorized_ip' );
//				delete_option( 'myeasy_showcredits' );

				echo '<script>window.location.href=\'options-general.php?page=myEASYwebally_settings\';</script>';
				exit();
				break;
				#
			#----------------
			case SAVE_BTN:
			#----------------
				#
				#	save the posted value in the database
				#
				if(isset($_POST['myewally_userKey']))
				{
					update_option( 'myewally_userKey', $_POST['myewally_userKey'] );
				}

				if((isset($_POST['myewally_userEmail']) && is_email($_POST['myewally_userEmail']))
					|| strlen($_POST['myewally_userEmail'])==0)
				{
					update_option( 'myewally_userEmail', $_POST['myewally_userEmail'] );
				}

				if(isset($_POST['myewally_emailfrq']))
				{
					update_option( 'myewally_emailfrq', $_POST['myewally_emailfrq'] );
				}

				if(isset($_POST['myeasy_showcredits']))
				{
					update_option( 'myeasy_showcredits', 1 );
				}
				else
				{
					update_option( 'myeasy_showcredits', 0 );
				}

				/**
				 * get the authorized ip from the main server
				 */
//				$authorized_ip = file_get_contents('http://myeasywp.com/service/auth-ip.php');  // 1.0.4
//				$authorized_ip = gethostbyname('services.myeasywp.com');                        // 1.0.4

				/**
				 * 14/06/2012
				 * on some servers URL file-access can be disabled in the server configuration
				 */
//				$authorized_ip = file_get_contents('https://services.myeasywp.com/auth-ip/');   // 1.1.0

				$response = wp_remote_post(

					'https://services.myeasywp.com/auth-ip/',
					array(

						'method' => 'POST',
						'timeout' => 5,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array('user-agent' => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'),
					)
				);

				$authorized_ip = '';

				if( is_wp_error( $response ) ) {

					/**
					 * Something went wrong!
					 */
					echo '<div style="warning">'
						  . '<h1>Sorry but it is not possible to connect to the myEASY licensing server: please try again later.</h1>'

						  . '<p>Error code: 999-'. $response['response']['code'] .'</p>'
//						  . '<p>Please <a class="myerror" href="' . $this->contactURL . '"><strong>get in touch</strong></a> at your soonest convenience.</p>'
						  . '</div>';
				}
				else if( (int) $response['response']['code'] != 200 ) {

					echo '<div style="warning">'
						  . '<h1>Sorry but it is not possible to connect to the myEASY licensing server: please try again later.</h1>'

						  . '<p>Error code: ' . $response['response']['code'] . '</p>'
//						  . '<p>Please <a class="myerror" href="' . $this->contactURL . '"><strong>get in touch</strong></a> at your soonest convenience.</p>'
						  . '</div>';
				}
				else {

					$authorized_ip = $response['body'];
				}

				update_option( 'myewally_authorized_ip', $authorized_ip );
				/* 14/06/2012: END */

				/**
				 * @since 1.0.4 : re-create the report file
				 */
//echo '{{{'.MYEWALLY_REPORT_FILE.'}}}';
//echo '{{{'.MYEWALLY_AUTHORIZED_IP.'}}}';
				define('MYEWALLY_AUTHORIZED_IP', $authorized_ip);

				if(file_exists(MYEWALLY_REPORT_FILE)) {

					@unlink(MYEWALLY_REPORT_FILE);
				}
				$MYEWALLY_frontend = new myEASYwebally_FRONTEND();
				$MYEWALLY_frontend->locale = MYEWALLY_LOCALE;

				break;

			default:
		}

		#
		#	populate the input fields when the page is loaded
		#
		if(!isset($_POST['myewally_userKey'])
			|| trim($_POST['myewally_userKey'])=='')	{ $_POST['myewally_userKey']	= get_option('myewally_userKey'); }

		if(!isset($_POST['myewally_userEmail'])
			|| trim($_POST['myewally_userEmail'])=='')	{ $_POST['myewally_userEmail']	= get_option('myewally_userEmail'); }

		if(!isset($_POST['myewally_emailfrq']))		    { $_POST['myewally_emailfrq']	= get_option('myewally_emailfrq'); }

		if(strlen($_POST['myewally_emailfrq'])==0) {
			$_POST['myewally_emailfrq'] = -1;
		}

		if(!isset($_POST['myeasy_showcredits'])) {

			$tmp = get_option('myeasy_showcredits');
			if(strlen($tmp)==0) { $tmp = 1;}

			$_POST['myeasy_showcredits']= $tmp;
		}

//		if(!is_email($_POST['myewally_userEmail']))
//		{
//			$_POST['myewally_userEmail'] = get_option('admin_email');
//		}

		/**
		 * is the notifier installed?
		 */
		if(!file_exists(ABSPATH.'myEASYwebally-notifier.php')) {

			if(is_writable(ABSPATH)) {

				copy(ABSPATH.'wp-content/plugins/myeasywebally/myEASYwebally-notifier.php', ABSPATH.'myEASYwebally-notifier.php');
			}
			else {

				echo '<div class="warning" style="margin-left:0px;">'

						.'<b>' . __('Hmmm...', $this->locale )
								. '</b>'

						.'<br /><i>'
							. __('I cannot write in your main WordPress path so, to complete the installation you need to manually copy the', $this->locale )
								. ' <b>' . __('`myEASYwebally-notifier.php`', $this->locale ) . '</b> '
							. __('file from the `', $this->locale )
								. '<b>' . ABSPATH . __('wp-content/plugins/myeasywebally`', $this->locale ) . '</b> '
							. __('directory to `', $this->locale )
								. '<b>' . ABSPATH.'myEASYwebally-notifier.php`</b>.'
							. '</i>'

					.'</div>'
				;
			}
		}

		if(strlen(trim($_POST['myewally_userKey']))=='')
		{
			?><form action="<?php echo SERVICE_SITE_URL; ?>" method="post" id="fGetKey" name="fGetKey" target="_blank"></form>
			<form name="plugin_settings" method="post" action=""><?php

			$NOTIFICATION_OK = true;

			?><div class="light">
				<div class="left"><?php
					#
					#	API request
					#
					echo '<b>'
								. __('Why do you need an API (Application Program Interface) key?', $this->locale )
								. '</b><i>'

								.'<br />' . __('By using your API key on each blogs/sites you are reponsable for, you "group" all of them under your account at ', $this->locale ) . SERVICE_SITE_NAME
								.'<br />' . __('Doing this you will be able to get a single email report showing all your "grouped" blogs/sites as well as conveniently change your preferences on a single place.', $this->locale )
							. '</i>'

					;

				?></div>
				<div class="right"><?php

					echo ''
							.'<i>'
									. __('To get your free API key, click on the button here below: a new window will open showing the form that will let you open your free account and get the API key.', $this->locale )
								. '</i>'
							.'<br />'
					;

				?><input class="button-primary" style="margin:12px 0;" type="button" name="btn" value="<?php echo GET_PIK_BTN; ?>" onclick="document.forms.fGetKey.submit();" />
				</div>
				<div style="clear:both;"></div>
			</div><?php

			if($NOTIFICATION_OK==true) {

				?><div class="light">
					<div class="left"><?php
						#
						#	Activation
						#
						echo '<b>' . __('Enter your API key to activate the plugin:', $this->locale )
										. '</b>'

							.'<br /><i>'
								. __('The best way to save time and keep everything under control is to use your API key to activate the plugin on every blogs/sites you are reponsable for.', $this->locale )

								. '<br /><br />' . __('This will allow you to get <b>one single email</b> including the information of all your blogs/sites.', $this->locale )
								. '</i>'
						;

					?></div>
					<div class="right">
						<input type="text" name="myewally_userKey" value="<?php echo $_POST['myewally_userKey']; ?>" size="50" maxlength="128" />
						<input class="button-primary" style="margin-left:12px;" type="submit" name="btn" value="<?php echo ACTIVATE_BTN; ?>" /><?php

						echo ''
								.'<p>'
									. __('Have you lost your API key?', $this->locale )
									. ' <a href="'.SERVICE_SITE_URL.'?p=reset-pwd" target="_blank">' . __('Click here to get it!', $this->locale ) . '</a>'
								.'</p>'

								.'<div style="color:#ffffff;background-color:#D54E21;margin:12px 100% 0 0;float:left;font-weight:bold;padding:2px 8px;-moz-border-radius:12px;">'
										. __('WARNING!', $this->locale )
									. '</div>'

									.'<p>'
										. __('For security reasons, the activation process does not verify your API key on the main server. If you enter a wrong API key you will never get notifications about this blog/site.', $this->locale )
										. '<br />' . __('Do not worry, you will be able to change your API key later.', $this->locale )
									.'</p>'
						;

					?></div><?php
			}

			?><div style="clear:both;"></div>
			</div>
			</form><?php
		}
		else
		{
			?><form action="<?php echo SERVICE_SITE_URL; ?>" method="post" id="fMainAcct" name="fMainAcct" target="_blank"></form>
			<form name="plugin_settings" method="post" action="">

			<div class="light">
				<div class="left"><?php
					#
					#	user API key (not editable)
					#
					echo '<b>' . __('Your API key:', $this->locale ) . '</b>'

						.'<br /><i>'
							. __('There are two methods to set your preferences.', $this->locale ) . ' '
							. '<ul>'
								. '<li>1) ' . __('You can fill the fields on this form to set the preferences on a site by site basis.', $this->locale ) . '</li>'
								. '<li>2) ' . __('You can edit the general preferences at ', $this->locale ) . ' ' . SERVICE_SITE_NAME . '.</li>'
								. '</ul>'
							. '</i>'
					;

				?><input class="button-secondary" style="margin:6px 0;" type="button" name="btn" value="<?php echo EDIT_MAIN_PREFS_BTN; ?>" onclick="document.forms.fMainAcct.submit();" /><?php

					if(defined('MYEWALLY_AUTHORIZED_IP') && strlen(MYEWALLY_AUTHORIZED_IP) > 0) {

						$tmp = MYEWALLY_AUTHORIZED_IP;
					}
					else {

						$tmp = $authorized_ip;
					}

					echo '<p><i>'
							. __('Using the same API key on different blogs/sites will group the reports so that you will get a single email for all your WordPress installations.', $this->locale )
							.'<br />'. $tmp
							. '</i></p>'
					;

				?></div>

				<div class="right">
					<input type="text" name="myewally_userKey" value="<?php echo $_POST['myewally_userKey']; ?>" size="50" maxlength="128" />
				</div>
				<div style="clear:both;"></div>
			</div>

			<div class="light">
				<div class="left"><?php
					#
					#	user email
					#
					echo '<b>' . __('Your email address?', $this->locale ) . '</b>'

						.'<br /><i>'
							. __('Enter an email address to get the notification emails sent to it.', $this->locale )
							. '<br />' . __('Leave the field empty to get the emails sent on the email address specified on your account on the server.', $this->locale )
							. '</i>';

				?></div>

				<div class="right">
					<input type="text" name="myewally_userEmail" value="<?php echo $_POST['myewally_userEmail']; ?>" size="50" maxlength="128" />
				</div>
				<div style="clear:both;"></div>
			</div>

			<div class="light">
				<div class="left"><?php
					#
					#	email frequency
					#
					echo '<b>' . __('Email frequency?', $this->locale ) . '</b>'

						.'<br /><i>' . __('Choose the frequency you like to get the notifications emails.', $this->locale )
									. '<br />' . __('If you choose to "Use the default value", the frequency you will get the email will be the one you set on your account on the server.', $this->locale )
							. '</i>'
					;

				?></div>

				<div class="right"><?php

						$checkedD ='';
						$checked0 ='';
						$checked1 ='';
						$checked2 ='';
						$checked3 ='';

						if($_POST['myewally_emailfrq']==-1){ $checkedD = ' checked="checked"'; }
						if($_POST['myewally_emailfrq']==0) { $checked0 = ' checked="checked"'; }
						if($_POST['myewally_emailfrq']==1) { $checked1 = ' checked="checked"'; }
						if($_POST['myewally_emailfrq']==2) { $checked2 = ' checked="checked"'; }
						if($_POST['myewally_emailfrq']==3) { $checked3 = ' checked="checked"'; }

					?>
					<input type="radio" name="myewally_emailfrq" id="efD" value="-1"<?php echo $checkedD; ?> /> <label for="efD"><?php echo __('Use the default value', $this->locale ); ?></label>
					<br /><input type="radio" name="myewally_emailfrq" id="ef1" value="1"<?php echo $checked1; ?> /> <label for="ef1"><?php echo __('Daily', $this->locale ); ?></label>
					<input type="radio" name="myewally_emailfrq" id="ef2" value="2"<?php echo $checked2; ?> /> <label for="ef2"><?php echo __('Weekly', $this->locale ); ?></label>
					<input type="radio" name="myewally_emailfrq" id="ef3" value="3"<?php echo $checked3; ?> /> <label for="ef3"><?php echo __('Monthly', $this->locale ); ?></label>
					<br /><input type="radio" name="myewally_emailfrq" id="ef0" value="0"<?php echo $checked0; ?> /> <label for="ef0"><?php echo __('No emails please', $this->locale ); ?></label>
				</div>
				<div style="clear:both;"></div>
			</div>

			<div style="margin:8px 0;text-align:center;"><?php
					#
					#	show credits
					#
					$checked ='';
//					if(!isset($_POST['myeasy_showcredits']) || $_POST['myeasy_showcredits']==1) { $checked = ' checked="checked"'; }
					if($_POST['myeasy_showcredits']==1) { $checked = ' checked="checked"'; }

					echo '' . __('We invested a lot of time to create this plugin and its related sites, please allow us to place a small credit in your blog footer, here is how it will look:', $this->locale )
							. '<br />'
							. MYEWALLY_FOOTER_CREDITS
					;

					?><p><input type="checkbox" name="myeasy_showcredits" value="1"<?php echo $checked; ?> />&nbsp;<?php

						echo __('Yes, I like to help you!', $this->locale )
								. ' &mdash; ' . __('If you decide not to show the credits, please consider to <a href="http://myeasywp.com/professional-open/" target="_blank">make a donation</a>: you will help us to keep up with the developent.', $this->locale )
							. '</p>'
						;

			?></div>

			<div class="button-separator">
				<input class="button-primary" style="margin:14px 12px;" type="submit" name="btn" value="<?php echo SAVE_BTN; ?>" />
			</div>

			<div class="light">
				<div class="left"><?php
					#
					#	full deactivatation
					#
					echo '<b>' . __('Plugin deactivation', $this->locale ) . '</b>'

						.'<br /><i>'
							. __('There can be certain circumstances where you may like to deactivate the plugin. For example when you are not responsible anymore of the blog/site maintenance.', $this->locale ) . ' '
								. '</i>'

							.'<br /><i>'
								. __('To completely deactivate the plugin, removing all your settings and your API key on this WordPress site, click on the', $this->locale )
									. ' "' . DEACTIVATE_FULL_BTN . '" '
									. __('button.', $this->locale )
							. '</i>'
					;

				?></div>

				<div class="right"><?php

					if(!is_writable(ABSPATH)) {

						echo '<div class="dark" style="padding:6px;margin:0 0 12px 0;">'

								.'<b>' . __('Remember!', $this->locale )
										. '</b><br />'

								.''
									. __('To complete the full deactivation you will also need to manually delete the following file:', $this->locale )
										. ' <b>`' . ABSPATH.'myEASYwebally-notifier.php`</b> '
									. __('I cannot do it automatically as I am not able to write/delete any file in your main WordPress directory:', $this->locale )
										. ' `' . ABSPATH.'` '
									. ''

							.'</div>'
						;
					}

				?><input class="button-secondary" type="submit" name="btn" value="<?php echo DEACTIVATE_FULL_BTN; ?>" />
				</div>
				<div style="clear:both;"></div>
			</div>

			</form><?php
		}

		echo '</div>';

		//include_once(MEH_PATH . '/inc/myEASYcom.php');
		measycom_camaleo_links();
	}
}


class myEASYwebally_FRONTEND extends myEASYwebally_CLASS {

	/**
	 * only executed in the frontend: visiting the site
	 */
	function myEASYwebally_FRONTEND() {

		/**
		 * creates a file with a list of available plugins
		 */
		$userKeyID   = get_option('myewally_userKey');

		if(strlen(trim($userKeyID))==0)
		{
			return;
		}

		$last_update = get_option('myewally_last_update');
		$userEmail   = get_option('myewally_userEmail');
		$emailfrq    = get_option('myewally_emailfrq');

		/**
		 * the latest WordPress version
		 */
		$tmp = get_transient('update_core');
		$currentWP = $tmp->updates[0]->current;

		/**
		 * the report file
		 */
		$file = MYEWALLY_REPORT_FILE;

		if(date('Ymd', $last_update) < date('Ymd',time()) || !file_exists($file))
		{
			$f = @fopen($file, 'w');

			if($f)
			{
				$header = "<?php\n"

/*							. '$tmp = parse_url($_SERVER[\'HTTP_REFERER\']);' . "\n"

						.'?>' . "\n"
*/
				;

				if(defined('MYEWALLY_DEBUG') && MYEWALLY_DEBUG==true) {

					/**
					 * debug only!
					 */
//					$header .= ''
//							. 'echo \'REMOTE_ADDR{\'.$_SERVER[\'REMOTE_ADDR\'].\'}\';' . "\n"
//							. 'echo \'HTTP_REFERER{\'.$_SERVER[\'HTTP_REFERER\'].\'}\';' . "\n"
//							. 'echo \'host{\'.$tmp[\'host\'].\'}\';' . "\n"
//					;
				}
				else {

					$authorized_ip = get_option('myewally_authorized_ip');

//					$header .= 'if($_SERVER[\'REMOTE_ADDR\']!=\'' . MYEWALLY_AUTHORIZED_IP . '\' '					/* 10/05/2012 */
					$header .= 'if(stripos(\''. $authorized_ip .'\', $_SERVER[\'REMOTE_ADDR\']) === false'	/* 10/05/2012 */
//								.'|| $tmp[\'host\']!=\'' . MYEWALLY_AUTHORIZED_HOST . '\' ) {' . "\n"
								.') {' . "\n"

//									. "\t" . 'echo '. MYEWALLY_AUTHORIZED_IP .' . \' \' . $_SERVER[\'REMOTE_ADDR\'] . "\n";' . "\n" /* debug only */
									. "\t" . 'die(\'good bye little cheek monkey!\');' . "\n"

								.'}' . "\n"
/*							.'?>' . "\n"        */
					;
				}

				$header .= ''
					.'?>' . "\n"

					.';---------------------------------------------------------' . "\n"
					.'; myEASYwebally export configuration file' . "\n"
					.'; do NOT touch to avoid issues!' . "\n"
					.';' . "\n"
					.'; Created by myEASYwebally version ' . $this->version . "\n"
					.'; For info visit http://services.myeasywp.com' . "\n"
					.';---------------------------------------------------------' . "\n\n"

					.'[wpinfo]' . "\n"
					.'version = "' . get_bloginfo('version') . '"' . "\n"
					.'current = "' . $currentWP . '"' . "\n\n"
				;

				fwrite($f, $header);

			    //require_once(ABSPATH . 'wp-load.php');//not needed here
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');

				$all_plugins = get_plugins();

				$special_ini_inp = array('"','=','&','%','!','£','$','^');
				$special_ini_out = array('MYEALLYDBLQUOTE','MYEALLYEQ','MYEALLYAND','MYEALLYPERCENT','MYEALLYEXCLAMATION', 'MYEALLYPOUND', 'MYEALLYDOLLAR', 'MYEALLYCARET');

				$record = '';
				$p = 1;
				foreach($all_plugins as $name => $info)
				{
//					$record .= 'echo \'' . $name . '||';

					$plugin_name = strtolower(basename($name));
					$plugin_path_name = strtolower(dirname($name));

					$record .= ''
								.'[plugin-' . $p .']' . "\n"
								.'InstallPath = "' . $plugin_path_name . '"' . "\n"
								.'ScriptName = "' . $plugin_name . '"' . "\n"
					;

					if(is_plugin_active($plugin_path_name . '/' . $plugin_name))
					{
						$record .= 'Active = "1"' . "\n";
					}
					else
					{
						$record .= 'Active = "0"' . "\n";
					}

					foreach($info as $key=>$val)
					{
						/**
						 * replaces non alfanumeric chars otherwise `parse_ini_file` will fail
						 */
						$val = str_replace($special_ini_inp, $special_ini_out, $val);
						//$val = addslashes($val);

						$record .= $key . ' = "' . $val . '"' . "\n";
					}

					@fwrite($f, $record . "\n");

					$record = '';
					$p++;
				}

				$footer = "\n"

						.'[misc]' . "\n"
						.'totalPlugins = "' . ($p - 1) . '"' . "\n"
						.'userKeyID = "' . $userKeyID . '"' . "\n"
						.'userEmail = "' . $userEmail . '"' . "\n"
						.'emailfrq = "' . $emailfrq . '"' . "\n"

						."\n"
						.'; END OF DATA' . "\n"
						.';---------------------------------------------------------' . "\n\n"
				;
				@fwrite($f, $footer);
				@fclose($f);

				update_option('myewally_last_update', time());

				if(defined('MYEWALLY_DEBUG') && MYEWALLY_DEBUG==true)
				{
					echo __( 'Report prepared!', MYEWALLY_LOCALE );

					$debug = file_get_contents($file);
					echo '<code>' . htmlspecialchars($debug) . '</code>';
				}
			}
			else
			{
				if(defined('MYEWALLY_DEBUG') && MYEWALLY_DEBUG==true)
				{
					echo __( 'myEASYwebally error! It was not possible to write the following file: ', MYEWALLY_LOCALE ) . $file;
				}
			}
		}
		else
		{
			if(defined('MYEWALLY_DEBUG') && MYEWALLY_DEBUG==true)
			{
				echo __( 'myEASYwebally: the file was already updated today!', MYEWALLY_LOCALE );
			}
		}

		/**
		 * on demand, show the credits on the footer
		 */
		if(get_option('myeasy_showcredits')==1 && !function_exists('myeasy_credits') && !defined('MYEASY_SHOWCREDITS')) {    /* 1.0.1 changed all references from 'myewally_showcredits' */

			define('MEBAK_FOOTER_CREDITS', '<div style="font-size:9px;text-align:center;">'
					.'<a href="http://myeasywp.com" target="_blank">Improve Your Life, Go The myEASY Way&trade;</a>'
					.'</div>');

			/**
			 * on demand, show the credits on the footer
			 */
			add_action('wp_footer', 'myeasy_credits');
			function myeasy_credits() {

				echo MEBAK_FOOTER_CREDITS;
				define('MYEASY_SHOWCREDITS', true);
			}
		}
	}
}

class myEASYwebally_BACKEND extends myEASYwebally_CLASS {

	/**
	 * only executed in the backend: admininstration
	 */
	function myEASYwebally_BACKEND() {

		$this->url = plugins_url('', __FILE__);

		add_action('admin_init', array($this, 'plugin_init'));
		add_action('admin_menu', array($this, 'plugin_setup'));
	}
}

?>