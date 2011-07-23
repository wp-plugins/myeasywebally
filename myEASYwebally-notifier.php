<?php
/*
myEASYwebally
Send the required information to the services server

Version: 1.0.4
Author: Ugo Grandolini aka "camaleo"
Author URI: http://myeasywp.com
*/

if(file_exists('wp-content/uploads/myEASYwebally-report.php')) {

	@include('wp-content/uploads/myEASYwebally-report.php');
}
else {

	echo -1;
}

?>