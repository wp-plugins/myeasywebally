<?php
/*
	myEASYcom.php: common functions for the myEASYwp plugins serie

	Author: Ugo Grandolini aka "Camaleo"
	Support site: http://myeasywp.com

	Copyright (C) 2010 Ugo Grandolini  (email : info@myeasywp.com)
*/
$version='1.0.2';


//define('MYEASYWP_DOMAIN', 'xps.lan');	# debug
//define('MYEASYWP_PATH', '/myEASYwp');	# debug


define('MYEASYWP_DOMAIN', 'myeasywp.com');
define('MYEASYWP_PATH', '');

if(!function_exists('measycom_camaleo_links'))
{
	function measycom_camaleo_links()
	{
		#	display the Camaleo links
		#
		if($admin_email == '') {

			$admin_email = get_option('admin_email');
		}

		echo '<div align="right" style="margin:12px 0 0 0;">'
				.'<form action="http://feedmailpro.com/subscriptions" method="post">'   // 1.0.2
					.'<img style="margin-right:8px;" src="http://myeasywp.com/common/img/camaleo.gif" align="absmiddle" /> '

					.'<a href="http://myeasywp.com" target="_blank">'._('The myEASY Series official site').'</a>'
// 1.0.2: BEG
//						.' | '
//					.'<a href="http://wordpress.org/extend/plugins/profile/camaleo" target="_blank">'._('Camaleo&rsquo;s plugins page at WordPress.org').'</a>'
						.' | '
					._('Be the first to know what\'s going on! Subscribe our newsletter now:')
					.' <input name="subscriber[feed_id]" value="674" type="hidden" />'
					.'<input name="subscriber[email]" size="15" type="text" value="'.$admin_email.'" />'
					.' <input class="button-primary" name="commit" value="Subscribe" type="submit" />'
				.'</form>'
// 1.0.2: END

			.'</div>'
		;
	}
}

if(!function_exists('measycom_sanitize_input'))
{
	function measycom_sanitize_input($field,$usebr=false,$removespaces=false)
	{
		#	remove unwanted chars in a field
		#	@since 1.0.1
		#
		$inp = array("\r\n","\n","\r");
		if($usebr)
		{
			$out = array('<br />','<br />','<br />');
		}
		else
		{
			$out = array('','','');
		}
		if($removespaces)
		{
			array_push($inp, ' ');
			array_push($out, '');
		}
		$clean = str_replace($inp, $out, $field);
		$clean = stripslashes($clean);
		return $clean;
	}
}

if(!function_exists('measycom_advertisement'))
{
	function measycom_advertisement($ref_code)
	{
		#	display the donation stuff
		#
		$src = 'http://'.MYEASYWP_DOMAIN.'/'.MYEASYWP_PATH.'/service/myads.php?p='.$ref_code;

		$h = measycom_getIframe_height('/donate/myads.php?h');
		if($h==0)
		{
			$h = (281-8);
		}

		?><div style="width:auto;height:<?php echo $h; ?>px;background:transparent;padding:0;margin:8px 0 0 0;">
			<iframe id="myFrame" width="100%" height="<?php echo $h; ?>px" scrolling="no" frameborder="0" border="0"
					style="background-color:#F7F6F1;padding:0;margin:0;border:0px solid #ffffff;height:<?php echo $h; ?>px" src="<?php echo $src; ?>"></iframe>
		</div><?php
	}
}

if(!function_exists('measycom_donate'))
{
	function measycom_donate($ref_code)
	{
		#	display the donation stuff
		#
		$src = 'http://'.MYEASYWP_DOMAIN.'/'.MYEASYWP_PATH.'/service/donate.php?p='.$ref_code;

		$h = measycom_getIframe_height('/service/donate.php?h');
		if($h==0)
		{
			$h = (281-8);
		}

		?><div style="width:auto;height:<?php echo $h; ?>px;background:transparent;padding:0;margin:20px 0 0 0;">
			<iframe id="myFrame" width="100%" height="<?php echo $h; ?>px" scrolling="no" frameborder="0" border="0"
					style="background-color:#F7F6F1;padding:0;margin:0;border:0px solid #ffffff;height:<?php echo $h; ?>px" src="<?php echo $src; ?>"></iframe>
		</div><?php
	}
}

if(!function_exists('measycom_getIframe_height'))
{
	function measycom_getIframe_height($domain_path)
	{
		#	$domain_path = '/service/donate.php?h'
		#
		$domain = MYEASYWP_DOMAIN;
		$domain_path = MYEASYWP_PATH.$domain_path;

		$h = 0;

		$fp = fsockopen($domain, 80, $errno, $errstr, 10);
		if(!$fp)
		{
			#
			#	HTTP ERROR
			#
			$h = 0;
		}
		else
		{
			#	get the info
			#
			$header = "GET $domain_path HTTP/1.1\r\n"
						."Host: $domain\r\n"
						."Connection: Close\r\n\r\n"
						//."Connection: keep-alive\r\n\r\n"
			;
			fwrite($fp, $header);

			$result = '';
			while (!feof($fp)) {
				$result .= fgets($fp, 1024);
			}

			$needle = '[hi]';
			$p = strpos($result, $needle, 0);
			if($p!==false)
			{
				$beg = $p + strlen($needle);
				$end = strpos($result, '[he]', $p);
				$h = substr($result, $beg, ($end-$beg));
			}

			fclose($fp);
		}
		return $h;
	}
}

?>