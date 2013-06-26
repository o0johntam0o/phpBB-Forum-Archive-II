<?php
/**
*
* @package Forum Archive II
* @version 1.1.3 of 19.03.2013
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
	'ARCHIVE_ADDITIONAL_CODE'			=> 'Additional code',
	'ARCHIVE_ADDITIONAL_CODE_EXPLAIN'	=> 'Append code to the HEAD tag<br />Example: &lt;script type=&quot;text/javascript&quot;&gt;alert(&quot;Blah!&quot;);&lt;/script&gt;<br />&lt;link href=&quot;myStyle.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;<br />...',
	'ARCHIVE_CUSTOM_STYLE'				=> 'Use custom style',
	'ARCHIVE_CUSTOM_STYLE_EXPLAIN'		=> 'To edit the style of the Archive page',
	'ARCHIVE_CUSTOM_STYLE_EXPLAIN2'		=> 'Examples: #000000,... or blue,...<br />Leave blank to restore the default value.',
	'ARCHIVE_STYLE_BG_MAIN'				=> 'Main background color',
	'ARCHIVE_STYLE_BG_HEADER'			=> 'Header background color',
	'ARCHIVE_STYLE_BG_BODY'				=> 'Body background color',
	'ARCHIVE_STYLE_BG_FOOTER'			=> 'Footer background color',
	'ARCHIVE_STYLE_BG_POSTS'			=> 'Posts background color',
	'ARCHIVE_STYLE_COLOR_COMMON'		=> 'Text color (common)',
	'ARCHIVE_STYLE_COLOR_COMMON_LINK'	=> 'Link color (common)',
	'ARCHIVE_STYLE_COLOR_COMMON_VLINK'	=> 'Visited link color (common)',
	'ARCHIVE_STYLE_COLOR_HEADER'		=> 'Text color (header)',
	'ARCHIVE_STYLE_COLOR_HEADER_LINK'	=> 'Link color (header)',
	'ARCHIVE_STYLE_COLOR_HEADER_VLINK'	=> 'Visited link color (header)',
	'ARCHIVE_STYLE_COLOR_TITLE'			=> 'Post titles',
	'ARCHIVE_STYLE_COLOR_AUTHOR'		=> 'Author name',
	
	'ARCHIVE_SAVED'						=> 'Forum Archive II settings updated',
	'ARCHIVE_LOG_MSG'					=> '<strong>Altered Forum Archive II settings</strong>',
));

?>