<?php
/*
Plugin Name: myEASYwebally
Plugin URI: http://myeasywp.com/plugins/myeasywebally/
Description: More than a simple plugin, myEASYwebally lets you save quite a good amount of time when doing your WordPress blog maintenance! You need a free <a href="https://services.myeasywp.com/?page=account-add">API key</a> to use it.
Version: 1.0.1
Author: Ugo Grandolini aka "camaleo"
Author URI: http://grandolini.com
*/
/*
	Copyright (C) 2010 Ugo Grandolini  (email : info@myeasywp.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	*/

define('MYEWALLY_DEBUG', false);

define('MYEWALLY_LOCALE', 'myEASYwebally');

define('MYEWALLY_FOOTER_CREDITS', '<div style="font-size:9px;text-align:center;"><a href="http://services.myeasywp.com" target="_blank">Improve Your Life, Go The myEASY Way&trade;</a></div>');

define('SAVE_BTN', __('Update Options', MYEWALLY_LOCALE ));
define('ACTIVATE_BTN', __('Activate', MYEWALLY_LOCALE ));
define('DEACTIVATE_BTN', __('Deactivate', MYEWALLY_LOCALE ));
define('DEACTIVATE_FULL_BTN', __('Fully deactivate', MYEWALLY_LOCALE ));
define('GET_PIK_BTN', __('Get your free API key', MYEWALLY_LOCALE ));
define('EDIT_PIK_BTN', __('Change your API key', MYEWALLY_LOCALE ));
define('EDIT_MAIN_PREFS_BTN', __('Edit your general preferences', MYEWALLY_LOCALE ));


if(defined('MYEWALLY_DEBUG') && MYEWALLY_DEBUG==true) {

	/**
	 * debug only!
	 */
	define('SERVICE_SITE_URL',          'http://camaleo/' );
	define('SERVICE_SITE_NAME',         'http://camaleo' );
	define('MYEWALLY_AUTHORIZED_HOST',  'wp291');
	define('MYEWALLY_AUTHORIZED_IP',    '127.0.0.1');
}
else {

	define('SERVICE_SITE_URL',          'http://services.myeasywp.com/' );
	define('SERVICE_SITE_NAME',         'http://services.myeasywp.com' );
	define('MYEWALLY_AUTHORIZED_HOST',  'services.myeasywp.com');

	define('MYEWALLY_AUTHORIZED_IP',    get_option('myewally_authorized_ip'));
}

define('MYEWALLY_REPORT_FILE', ABSPATH . 'wp-content/uploads/myEASYwebally-report.php');

require_once('inc/myEASYcom.php');
require_once('class.myeasywebally.php');

if(is_admin()) {

//	global $_wp_contextual_help;    //todo: avoid to show other stuff in the contextual help?
//var_dump($_wp_contextual_help);


	$MYEWALLY_backend = new myEASYwebally_BACKEND();
	$MYEWALLY_backend->main_plugin = __FILE__;
	$MYEWALLY_backend->locale = MYEWALLY_LOCALE;
	$MYEWALLY_backend->css = 'style';
	$MYEWALLY_backend->js = 'scripts';
	$MYEWALLY_backend->register_plugin_settings(__FILE__);   // adding a link to the settings page in the plugin list page

	/**
	 * help contents
	 */
	//	$_backend->help = '*** myEASYwebally HELP ***'; //todo?

	/**
	 * dashboard plugin own item
	 */
	$datetime = get_option('date_format') . ' ' . get_option('time_format');
	$time_gmt = get_option('myewally_last_update') + (get_option('gmt_offset')*3600);

	$MYEWALLY_backend->dash_title = '<span>' . __( 'myEASYwebally info', MYEWALLY_LOCALE ) . '</span>';
	$MYEWALLY_backend->dash_contents = ''
							. '<p>' . __( 'Last update sent to the main server: ', MYEWALLY_LOCALE ) . date($datetime, $time_gmt) . '</p>'
	;

} else {

	$MYEWALLY_frontend = new myEASYwebally_FRONTEND();
	$MYEWALLY_frontend->locale = MYEWALLY_LOCALE;

}

//var_dump($_SERVER);
//echo $_SERVER['HTTP_REFERER'].'<br>';
//$tmp = $_SERVER['HTTP_REFERER'];
//$tmpa = explode('/', $tmp);
//echo $tmpa[0].'<br>';

//die();

?>