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

// Frontend User Permit INIT
// =========================

$FEUSER_PERMIT = array(
	'regkey'		=> 'feuserpermit',
	'permitted'		=> false,
	'locked'		=> array(),
	'config'		=> array('logout_id_or_alias'=>''),
	'is_permitted'	=> '',
	'not_permitted'	=> '',
	'login'			=> '',
	'password'		=> '',
	'error'			=> array()
);

$content['cat_id'] = (int) $content['cat_id'];

// Check which levels are locked first
$data = _dbGet('phpwcms_userdetail', 'detail_int1', 'detail_regkey='._dbEscape($FEUSER_PERMIT['regkey']).' AND detail_int1 > 0', 'detail_int1');

if(isset($data[0]['detail_int1'])) {
	foreach($data as $value) {
		$value = (int) $value['detail_int1'];
		$FEUSER_PERMIT['locked'][$value] = $value;
		$content['struct'][$value]['acat_hidden'] = 1;
	}
}

// Handle Login or check session
if(isset($_POST['feuserpermit_login'])) {

	unset($_SESSION['feuserpermit']);

	$FEUSER_PERMIT['login']		= slweg($_POST['feuserpermit_login'], 100);
	$FEUSER_PERMIT['password']	= isset($_POST['feuserpermit_pwd']) ? slweg($_POST['feuserpermit_pwd'], 100) : '';

	if($FEUSER_PERMIT['login'] && $FEUSER_PERMIT['password']) {
		// Check Login
		$where  = 'detail_regkey='._dbEscape($FEUSER_PERMIT['regkey']).' AND detail_aktiv!=9 AND '; //AND detail_int1='.$content['cat_id'].'
		$where .= 'detail_login='._dbEscape($FEUSER_PERMIT['login']).' AND detail_password='._dbEscape(md5($FEUSER_PERMIT['password']));
		$data = _dbGet('phpwcms_userdetail', '*', $where);

		if(!isset($data[0]['detail_login'])) {
			$FEUSER_PERMIT['error']['general'] = 'The entered login or password is incorrect.';
		} elseif($data[0]['detail_aktiv'] != 1) {
			$FEUSER_PERMIT['error']['general'] = 'Account is inactive.';
		} else {
			$_SESSION['feuserpermit'] = array(
				'uid'	=> (int) $data[0]['detail_id'],
				'login'	=> $data[0]['detail_login'],
				'cid'	=> (int) $data[0]['detail_int1']
			);
			$FEUSER_PERMIT['session_id'] = session_id();
			if(!isset($_SESSION[$FEUSER_PERMIT['session_id']])) {
				$_SESSION[$FEUSER_PERMIT['session_id']] = $data[0]['detail_login'];
			}

			if($content['cat_id'] !== $_SESSION['feuserpermit']['cid']) {
				if($content['struct'][ $_SESSION['feuserpermit']['cid'] ]['acat_alias']) {
					$FEUSER_PERMIT['target'] = $content['struct'][ $_SESSION['feuserpermit']['cid'] ]['acat_alias'];
				} else {
					$FEUSER_PERMIT['target'] = 'id='.$_SESSION['feuserpermit']['cid'];
				}
				headerRedirect(abs_url(array(), array(), $FEUSER_PERMIT['target']), 302);
			}

			headerAvoidPageCaching();
			$content['struct'][ $content['cat_id'] ]['acat_hidden'] = 0;

			// we can give access here
			$FEUSER_PERMIT['permitted'] = true;
		}
	}
	if($FEUSER_PERMIT['login'] === '') {
		$FEUSER_PERMIT['error']['login'] = 'Login is mandatory';
	}
	if($FEUSER_PERMIT['password'] === '') {
		$FEUSER_PERMIT['error']['password'] = 'Password is mandatory';
	}
} elseif(isset($_POST['feuserpermit_logout']) || isset($_GET['feuser-logout'])) {

	unset($_SESSION['feuserpermit'], $_GET['feuser-logout'], $_getVar['feuser-logout']);

}

// Check Session based permission
if(!$FEUSER_PERMIT['permitted'] && !empty($_SESSION['feuserpermit']['uid'])) {
	// Is the user active
	$where  = 'detail_regkey='._dbEscape($FEUSER_PERMIT['regkey']).' AND detail_aktiv=1 AND detail_int1='.$_SESSION['feuserpermit']['cid'].' AND ';
	$where .= 'detail_id='._dbEscape($_SESSION['feuserpermit']['uid']).' AND detail_login='._dbEscape($_SESSION['feuserpermit']['login']);
	$data = _dbGet('phpwcms_userdetail', 'detail_id', $where);
	if(isset($data[0]['detail_id'])) {
		$content['struct'][ $_SESSION['feuserpermit']['cid'] ]['acat_hidden'] = 0;
		if($_SESSION['feuserpermit']['cid'] === $content['cat_id']) {
			$FEUSER_PERMIT['permitted'] = true;
		}
	}
}

?>