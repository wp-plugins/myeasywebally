<?php
function mailchimp(){

	if(!$_GET['email']) {

		return 'No email address provided';
	}

	if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['email'])) {

		return 'Email address is invalid!';
	}

	require_once('MCAPI.class.php');
	$api = new MCAPI('59b03eebd9fbaae1c670d87a972f05db-us2');
	$list_id = 'a0bad908a6';

	if($api->listSubscribe($list_id, $_GET['email'], '') === true) {

		return 'Success! Check your email to confirm sign up.';
	}
	else {

		return 'Error: ' . $api->errorMessage;
	}
}

/**
 * execute when called by ajax
 */
if($_GET['ajax']) { echo mailchimp(); }
