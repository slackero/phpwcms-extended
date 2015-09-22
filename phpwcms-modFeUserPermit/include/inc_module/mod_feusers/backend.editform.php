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



?>
<h1 class="title" style="margin-bottom:10px"><?php echo $BLM['listing_title'] ?></h1>

<form action="<?php echo MODULE_HREF ?>&amp;edit=<?php echo $plugin['data']['detail_id'] ?>" method="post" style="background:#F3F5F8;border-top:1px solid #92A1AF;border-bottom:1px solid #92A1AF;margin:0 0 5px 0;padding:10px 8px 15px 8px">
<input type="hidden" name="detail_id" value="<?php echo $plugin['data']['detail_id'] ?>" />
<table border="0" cellpadding="0" cellspacing="0" width="100%" summary="">

	<?php

	if(isset($plugin['error'])) {

	?>
	<tr>
		<td>&nbsp;</td>
		<td class="v12 error"><?php echo implode('<br />', $plugin['error']) ;?></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>
	<?php
	}

	?>

	<tr>
		<td>&nbsp;</td>
		<td class="v12"><?php echo $BLM['forminfo'] ?></td>
	</tr>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>

<?php

	foreach($plugin['fields'] as $key => $value) {

		switch($value) {

			case 'STRING':

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td align="right" class="chatlist" nowrap="nowarp">'.$BLM[$key].':&nbsp;</td>'.LF;
		echo '<td><input name="'.$key.'" type="text" id="'.$key.'" class="v12" style="width:400px;" value="'.html_specialchars($plugin['data'][$key]).'" size="30" maxlength="200" /></td>'.LF;
		echo '</tr>'.LF;
							break;

			case 'INT':

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td align="right" class="chatlist" nowrap="nowarp">'.$BLM[$key].':&nbsp;</td>'.LF;
		echo '<td><input name="'.$key.'" type="text" id="'.$key.'" class="v12" style="width:150px;" value="'.(empty($plugin['data'][$key]) ? '' : $plugin['data'][$key]).'" size="11" maxlength="11" /></td>'.LF;
		echo '</tr>'.LF;
							break;

			case 'PASSWORD':

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td align="right" class="chatlist" nowrap="nowarp">'.$BLM[$key].':&nbsp;</td>'.LF;
		echo '<td><input name="'.$key.'" type="password" id="'.$key.'" class="v12" style="width:400px;" value="" size="30" maxlength="200" autocomplete="off" /></td>'.LF;
		echo '</tr>'.LF;
							break;

			case 'CHECK':

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td>&nbsp;</td>'.LF;
		echo '<td><table border="0" cellpadding="0" cellspacing="0" summary=""><tr><td><input type="checkbox" name="'.$key.'" id="'.$key.'" value="1"';
		is_checked($plugin['data'][$key], 1);
		echo ' /></td><td><label for="'.$key.'">'.$BLM[$key].'</label></td></tr></table></td>'.LF;
		echo '</tr>'.LF;
							break;

			case 'SELECT':

		$plugin['select'] = array();

		if(isset( $plugin['fields_' . $key ] )) {

			if(is_array($plugin['fields_' . $key ])) {

				$plugin['select'] = $plugin['fields_' . $key ];

			// check if the string is a valid function to retrieve field options/values
			} elseif(is_string($plugin['fields_' . $key ])) {

				if(function_exists($plugin['fields_' . $key ])) {

					$plugin_function = $plugin['fields_' . $key ];

					$plugin['select'] = $plugin_function();

				}
				// maybe elseif here could be used to check string against imploded
				// array members separated by "," or any other delimeter
			}
		}

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td align="right" class="chatlist">'.$BLM[$key].':&nbsp;</td>'.LF;
		echo '<td><select name="'.$key.'" id="'.$key.'" class="v12" style="max-width:400px">' .LF;

		foreach($plugin['select'] as $item => $row) {
			echo '	<option value="' . html_specialchars($item) .'"';
			if( $plugin['data'][$key] == $item ) {
				echo ' selected="selected"';
			}
			echo '>' . html_specialchars(trim($row)) . '</option>' . LF;
		}

		echo '</select></td>'.LF;'</tr>'.LF;
							break;


				// Custom structure level menu
			case 'STRUCT':

		echo '<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="5" /></td></tr>'.LF;
		echo '<tr>'.LF;
		echo '<td align="right" class="chatlist">'.$BLM[$key].':&nbsp;</td>'.LF;
		echo '<td><select name="'.$key.'" id="'.$key.'" class="v12" style="max-width:400px">' .LF;
		echo '<option value="0">'.$BL['be_ftptakeover_needed'].'</option>';
		echo struct_select_menu(0, 0, $plugin['data'][$key]);
		echo '</select>';

		echo '</td>'.LF;'</tr>'.LF;
							break;
		}

	}
?>

	<tr><td colspan="2"><img src="img/leer.gif" alt="" width="1" height="10" /></td></tr>

	<tr>
		<td>&nbsp;</td>
		<td>
			<input name="submit" type="submit" class="button10" value="<?php echo empty($plugin['data']['detail_id']) ? $BL['be_admin_fcat_button2'] : $BL['be_article_cnt_button1'] ?>" />
			<input name="save" type="submit" class="button10" value="<?php echo $BL['be_article_cnt_button3'] ?>" />
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="new" type="button" class="button10" value="<?php echo ucfirst($BL['be_msg_new']) ?>" onclick="location.href='<?php echo decode_entities(MODULE_HREF) ?>&edit=0';return false;" />
			<input name="close" type="button" class="button10" value="<?php echo $BL['be_admin_struct_close'] ?>" onclick="location.href='<?php echo decode_entities(MODULE_HREF) ?>';return false;" />
		</td>
	</tr>

</table>

</form>