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

// Frontend User Permit RENDER
// ===========================

if(strpos($content['all'], '[PERMITTED')) {

	// Load template
	if(is_file($phpwcms['modules']['feuserpermit']['path'].'template/'.$phpwcms['default_lang'].'.tmpl')) {
		$_tmpl = @file_get_contents($phpwcms['modules']['feuserpermit']['path'].'template/'.$phpwcms['default_lang'].'.tmpl');
	} else {
		$_tmpl = @file_get_contents($phpwcms['modules']['feuserpermit']['path'].'template/default.tmpl');
	}

	$FEUSER_PERMIT['is_permitted']					= get_tmpl_section('IS_PERMITTED', $_tmpl);
	$FEUSER_PERMIT['not_permitted']					= get_tmpl_section('NOT_PERMITTED', $_tmpl);
	$FEUSER_PERMIT['config']						= array_merge($FEUSER_PERMIT['config'], parse_ini_str(get_tmpl_section('CONFIG', $_tmpl), false));
	$FEUSER_PERMIT['config']['logout_id_or_alias']	= trim($FEUSER_PERMIT['config']['logout_id_or_alias']);

	unset($_tmpl);

	if($FEUSER_PERMIT['permitted']) {

		$FEUSER_PERMIT['is_permitted'] = str_replace('{feuserpermit_action}', rel_url(array('feuser-logout'=>1), array(), $FEUSER_PERMIT['config']['logout_id_or_alias']), $FEUSER_PERMIT['is_permitted']);
		$content['all'] = render_cnt_template($content['all'], 'PERMITTED', $FEUSER_PERMIT['is_permitted'], '');

	} else {

		// Handle Login Errors
		if(!isset($FEUSER_PERMIT['error']['general'])) {
			$FEUSER_PERMIT['error']['general'] = count($FEUSER_PERMIT['error']) ? ' ' : ''; //implode(LF, $FEUSER_PERMIT['error']);
		}
		$FEUSER_PERMIT['not_permitted'] = render_cnt_template($FEUSER_PERMIT['not_permitted'], 'ERROR', $FEUSER_PERMIT['error']['general']);
		$FEUSER_PERMIT['not_permitted'] = render_cnt_template($FEUSER_PERMIT['not_permitted'], 'ERROR:LOGIN', isset($FEUSER_PERMIT['error']['login']) ? $FEUSER_PERMIT['error']['login'] : '');
		$FEUSER_PERMIT['not_permitted'] = render_cnt_template($FEUSER_PERMIT['not_permitted'], 'ERROR:PASSWORD', isset($FEUSER_PERMIT['error']['password']) ? $FEUSER_PERMIT['error']['password'] : '');
		$FEUSER_PERMIT['not_permitted'] = str_replace('{feuserpermit_login}', html_specialchars($FEUSER_PERMIT['login']), $FEUSER_PERMIT['not_permitted']);
		$FEUSER_PERMIT['not_permitted'] = str_replace('{feuserpermit_action}', rel_url(array(), array('feuser-logout')), $FEUSER_PERMIT['not_permitted']);

		if(isset($FEUSER_PERMIT['locked'][ $content['cat_id'] ])) {

			$content['all'] = render_cnt_template($content['all'], 'PERMITTED', '', $FEUSER_PERMIT['not_permitted']);

		} elseif(!empty($_SESSION['feuserpermit']['uid'])) {

			$FEUSER_PERMIT['is_permitted'] = str_replace('{feuserpermit_action}', rel_url(array('feuser-logout'=>1), array(), $FEUSER_PERMIT['config']['logout_id_or_alias']), $FEUSER_PERMIT['is_permitted']);
			$content['all'] = render_cnt_template($content['all'], 'PERMITTED', $FEUSER_PERMIT['is_permitted'], '');

		} else {

			// Delete the PERMITTED replacement Tags
			$content['all'] = str_replace(array('[PERMITTED]', '[/PERMITTED]'), '', $content['all']);

			// Replace by Login Form
			$content['all'] = str_replace('{PERMITTED}', $FEUSER_PERMIT['not_permitted'], $content['all']);

			// Remove the PERMITTED_ELSE section
			$content['all'] = replace_cnt_template($content['all'], 'PERMITTED_ELSE', '');

		}
	}
}

unset($FEUSER_PERMIT);

?>