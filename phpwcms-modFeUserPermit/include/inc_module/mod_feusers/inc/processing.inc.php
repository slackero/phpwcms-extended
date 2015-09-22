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

// set fields

$plugin['fields'] = array(
	'detail_login'		=> 'STRING',	// Benutzername
	'detail_password'	=> 'PASSWORD',	// Passwort
	//'detail_company'	=> 'STRING',	// Firma
	//'detail_title'		=> 'STRING',	// Anrede
	//'detail_firstname'	=> 'STRING',	// Vorname
	//'detail_lastname'	=> 'STRING',	// Name
	//'detail_street'		=> 'STRING',	// Strasse
	//'detail_zip'		=> 'STRING',	// Postleitzahl
	//'detail_city'		=> 'STRING',	// Ort
	//'detail_fon'		=> 'STRING',	// Telefon
	//'detail_fax'		=> 'STRING',	// Telefax
	'detail_int1'		=> 'STRUCT',		// Seitenebene
	//'detail_website'	=> 'STRING',	// Website
	//'detail_email'		=> 'STRING',	// Email
	//'detail_public'		=> 'CHECK',
	'detail_aktiv'		=> 'CHECK'
);


$plugin['id'] = isset($_GET['edit']) ? intval($_GET['edit']) : 0;

// process post form
if(isset($_POST['detail_login'])) {

	$plugin['data'] = array(
		'detail_id'		=> intval($_POST['detail_id']),
		'detail_regkey'	=> MODULE_REGKEY
	);

	foreach($plugin['fields'] as $key => $value) {
		switch($value) {
			case 'PASSWORD':
							$plugin['data'][$key] = slweg($_POST[$key], 0, false);
							break;
			case 'SELECT':
			case 'STRING':	$plugin['data'][$key] = isset($_POST[$key]) ? clean_slweg($_POST[$key]) : '';
							break;

			case 'STRUCT':
			case 'INT':		$plugin['data'][$key] = empty($_POST[$key]) ? 0 : intval($_POST[$key]);
							break;
			case 'CHECK':	$plugin['data'][$key] = empty($_POST[$key]) ? 0 : 1;
							break;

		}
	}

	/*
	if(empty($plugin['data']['detail_email']) || !is_valid_email($plugin['data']['detail_email'])) {
		$plugin['error']['detail_email'] = $BLM['error_email'];
	}
	*/

	if(!$plugin['id'] && empty($plugin['data']['detail_password'])) {
		$plugin['error']['detail_password'] = $BLM['error_password'];
	} elseif(!empty($plugin['data']['detail_password']) && strlen($plugin['data']['detail_password'])<5) {
		$plugin['error']['detail_password'] = $BLM['error_password_short'];
	}


	$_testuser = _dbGet('phpwcms_userdetail', '*', 'detail_id != '.$plugin['id'].' AND detail_login='._dbEscape($plugin['data']['detail_login']));
	if(isset($_testuser[0]['detail_id'])) {
		$plugin['error']['detail_login'] = $BLM['error_login'];
	}

	$plugin['data']['detail_int1'] = (int) $plugin['data']['detail_int1'];
	if(!$plugin['data']['detail_int1']) {
		$plugin['error']['detail_int1'] = $BLM['error_int1'];
	}


	if(!isset($plugin['error'])) {

		$_password = $plugin['data']['detail_password'];

		$plugin['data']['detail_password'] = md5($plugin['data']['detail_password']);

		if($plugin['data']['detail_id']) {

			// UPDATE
			$sql  = 'UPDATE '.DB_PREPEND.'phpwcms_userdetail SET ';

			$sql_fields = array();

			foreach($plugin['fields'] as $key => $value) {
				$sql_fields[] = $key."='".aporeplace($plugin['data'][$key])."'";
			}

			if(empty($_password)) {
				unset($plugin['data']['detail_password'], $sql_fields['detail_password']);
			}

			$sql_fields[] = "detail_login='".aporeplace($plugin['data']['detail_login'])."'";

			$sql .= implode(', ', $sql_fields);

			$sql .= "WHERE detail_id=".$plugin['data']['detail_id'].' AND ';
			$sql .= 'detail_regkey='._dbEscape(MODULE_REGKEY);

			if(@_dbQuery($sql, 'UPDATE')) {
				/*
				if($plugin['data']['detail_aktiv']) {

					sendActivationEmail( array(

						detail_login'		=> $plugin['data']['detail_login'],
						detail_email'		=> $plugin['data']['detail_email'],
						detail_title'		=> $plugin['data']['detail_title'],
						detail_firstname'	=> $plugin['data']['detail_firstname'],
						detail_lastname'	=> $plugin['data']['detail_lastname'],
						detail_pwd'		=> $_password
					) );
				}
				*/

				if(isset($_POST['save'])) {
					headerRedirect(decode_entities(MODULE_HREF));
				}

			} else {
				$plugin['error']['update'] = 'MySQL error: '.mysql_error();
			}

		} else {

			// INSERT
			$sql_fields = $plugin['fields'];
			$sql_fields['detail_regkey'] = MODULE_REGKEY;

			$plugin['data']['detail_regkey'] = $sql_fields['detail_regkey'];

			$sql  = 'INSERT INTO '.DB_PREPEND.'phpwcms_userdetail (';
			foreach($sql_fields as $key => $value) {
				$sql_fields[$key] = $key;
			}
			$sql .= implode(', ', $sql_fields);
			$sql .= ') VALUES (';
			foreach($sql_fields as $key => $value) {
				$sql_fields[$key] = "'".aporeplace($plugin['data'][$key])."'";
			}

			$sql .= implode(', ', $sql_fields);

			$sql .= ')';

			$result = _dbQuery($sql, 'INSERT');

			if($result) {
				$plugin['id']					= $result['INSERT_ID'];
				$plugin['data']['detail_id']	= $result['INSERT_ID'];

				/*
				if($plugin['data']['detail_aktiv']) {

					sendActivationEmail( array(

						'detail_login'		=> $plugin['data']['detail_login'],
						'detail_email'		=> $plugin['data']['detail_email'],
						'detail_title'		=> $plugin['data']['detail_title'],
						'detail_firstname'	=> $plugin['data']['detail_firstname'],
						'detail_lastname'	=> $plugin['data']['detail_lastname'],
						'detail_pwd'		=> $_password
					) );
				}
				*/

				if(isset($_POST['save'])) {
					headerRedirect(decode_entities(MODULE_HREF));
				}

			} else {
				$plugin['error']['update'] = 'MySQL error: '.mysql_error();
			}
		}
	}
}

// try to read entry from database
if($plugin['id'] && !isset($plugin['error'])) {

	$sql  = 'SELECT * FROM '.DB_PREPEND.'phpwcms_userdetail WHERE detail_regkey='._dbEscape(MODULE_REGKEY).' AND detail_id='.$plugin['id'].' AND detail_pid=0';
	$plugin['data'] = _dbQuery($sql);
	$plugin['data'] = $plugin['data'][0];

}

// default values
if(empty($plugin['data'])) {

	$plugin['data'] = array('detail_id' => 0);

	foreach($plugin['fields'] as $key => $value) {

		switch($value) {

			case 'PASSWORD':
			case 'STRING':
			case 'INT':		$plugin['data'][$key] = '';
							break;
			
			case 'STRUCT':
			case 'CHECK':	$plugin['data'][$key] = 0;
							break;

		}

	}

}


?>