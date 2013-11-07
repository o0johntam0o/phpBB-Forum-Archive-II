<?php
/**
*
* @package Forum Archive II
* @version 1.1.3 of 19.03.2013
* @copyright (c) 2012 o0johntam0o - o0johntam0o@gmail.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// NOTE TO TRANSLATORS:  Text in parenthesis refers to keys on the keyboard
// Force text encoding to UTF-8 without BOM: Huỳnh Bửu Tâm

$lang = array_merge($lang, array(
	'ARCHIVE_VIEW'						=> 'View the archive of ',
	'ARCHIVE_VIEW_FULL_STORY'			=> '(F)',
	'ARCHIVE_VIEW_FULL_STORY_EXPLAIN'	=> 'Click to view full story of ',
	'ARCHIVE_BACK'						=> 'Back to parent forum',
	'ARCHIVE_BACK_MAIN'					=> 'Back to main archive',
	'ARCHIVE_FORUM_PASSWORD'			=> 'Please login in order to access this forum',
	'ARCHIVE_NO_FORUM_OR_NO_FORUMS'		=> 'This page is not available. This error occurred due to:<br />- This board has no forums<br />- Your request is incorrect<br />- This is a forum link<br />- Archive MOD was disabled by the administrator',
	'ARCHIVE_MOD'						=> 'ARCHIVE',
	'ARCHIVE_PAGE'						=> 'Page ',
	'ARCHIVE_JUMP'						=> 'Jump to Archive',
));

?>
