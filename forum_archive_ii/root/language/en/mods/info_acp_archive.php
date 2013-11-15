<?php
/**
*
* @package Forum Archive II
* @version 1.1.4 of 14.07.2013
* @copyright (c) 2012 o0johntam0o - o0johntam0o@gmail.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
// Force text encoding to UTF-8 without BOM: Huỳnh Bửu Tâm

$lang = array_merge($lang, array(
	'ARCHIVE_TITLE'						=> 'Forum Archive II',
	'ARCHIVE_TITLE_ACP'					=> 'Forum Archive II settings',
	
	'ARCHIVE_ENABLE'					=> 'Enable Forum Archive II',
	'ARCHIVE_ENABLE_EXPLAIN'			=> 'Do you want to use this mod now?',
	'ARCHIVE_TOPICS_PER_PAGE'			=> 'Topics per page',
	'ARCHIVE_TOPICS_PER_PAGE_EXPLAIN'	=> 'Number of topics shown in each page',
	'ARCHIVE_POSTS_PER_PAGE'			=> 'Posts per page',
	'ARCHIVE_POSTS_PER_PAGE_EXPLAIN'	=> 'Number of posts shown in each page',
	'ARCHIVE_HIDE_MOD'					=> 'Hide/Hidden MOD',
	'ARCHIVE_HIDE_MOD_EXPLAIN'			=> 'Are you using the MOD that using BBCode [Hide] or [Hidden] to hide the posts contents',
	
	'ARCHIVE_SAVED'						=> 'Forum Archive II settings updated',
	'ARCHIVE_LOG_MSG'					=> '<strong>Altered Forum Archive II settings</strong>',
));

?>
