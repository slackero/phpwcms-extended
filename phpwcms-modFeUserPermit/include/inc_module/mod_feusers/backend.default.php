<?php
/**
 * phpwcms content management system
 *
 * @author Oliver Georgi <og@phpwcms.org>
 * @copyright Copyright (c) 2002-2015, Oliver Georgi
 * @license http://opensource.org/licenses/GPL-2.0 GNU GPL-2
 * @link http://www.phpwcms.de
 *
 **/

// ----------------------------------------------------------------
// obligate check for phpwcms constants
if (!defined('PHPWCMS_ROOT')) {
   die("You Cannot Access This Script Directly, Have a Nice Day.");
}
// ----------------------------------------------------------------


// first check if neccessary db exists
if(isset($phpwcms['modules'][$module]['path'])) {

	// module default stuff

	// put translation back to have easier access to it - use it as relation
	$BLM = & $BL['modules'][$module];
	define('MODULE_HREF', 'phpwcms.php?do=modules&amp;module='.$module);
	define('MODULE_REGKEY', 'feuserpermit');

	if(isset($_GET['edit'])) {

		// handle posts and read data
		include_once($phpwcms['modules'][$module]['path'].'inc/processing.inc.php');

		// edit form
		if(!function_exists('struct_select_menu')) {
			include_once(PHPWCMS_ROOT.'/include/inc_lib/article.functions.inc.php');
		}
		include_once($phpwcms['modules'][$module]['path'].'backend.editform.php');

	} elseif(isset($_GET['verify'])) {

		// active/inactive
		$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_userdetail SET ';
		$sql .= "detail_aktiv=".(intval($_GET['verify']) ? 1 : 0)." ";
		$sql .= "WHERE detail_regkey="._dbEscape(MODULE_REGKEY)." AND detail_id=".intval($_GET['editid']);
		@_dbQuery($sql, 'UPDATE');

		// send activation email
		/*
		$udata = _dbQuery('SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_regkey='._dbEscape(MODULE_REGKEY).' AND detail_id='.intval($_GET['editid']).' LIMIT 1');
		if(isset($udata[0]) && intval($_GET['verify'])) {

		}
		*/

		headerRedirect(decode_entities(MODULE_HREF));

	} elseif(isset($_GET['delete'])) {

		// delete
		$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_userdetail SET detail_aktiv=9 ';
		$sql .= "WHERE detail_regkey="._dbEscape(MODULE_REGKEY)." AND detail_id=".intval($_GET['delete']);
		@_dbQuery($sql, 'UPDATE');
		headerRedirect(decode_entities(MODULE_HREF));

	} else {

		// listing
		include_once($phpwcms['modules'][$module]['path'].'backend.listing.php');

	}

}

//function sendActivationEmail($udata) {
//	$fe_text  = 'Hallo '.trim($udata['detail_title'] . ' ' . trim( $udata['detail_firstname'].' '.$udata['detail_lastname']) ) . LF . LF;
//	$fe_text .= 'Ihr Zugang wurde soeben freigeschaltet.' . LF . LF;
//	$fe_text .= 'Besuchen Sie gleich unsere Homepage und loggen Sie sich mit Ihren Benutzerdaten ein:' . LF;
//	$fe_text .= PHPWCMS_URL . LF . LF;
//
//	$fe_text .= 'Login:    ' . $udata['detail_login'] . LF;
//	if(!empty($udata['detail_pwd'])) {
//		$fe_text .= 'Passwort: ' . $udata['detail_pwd'] . LF;
//	}
//	$fe_text .= LF . LF;
//
//	$fe_text .= 'Mit besten Grüßen' . LF;
//
//	sendEmail(array(
//			'recipient'		=> strtolower($udata['detail_email']),
//			'toName'		=> trim($udata['detail_firstname'].' '.$udata['detail_lastname']),
//			'subject'		=> 'Freischaltung Zugang',
//			'text'			=> $fe_text,
//			'from'			=> 'test@example.com',
//			'fromName'		=> 'Admin',
//			'sender'		=> 'test@example.com' ));
//}

?>