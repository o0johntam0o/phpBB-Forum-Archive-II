<?php
/**
*
* @package Forum Archive II
* @version 1.1.4 of 14.07.2013
* @copyright (c) 2012 o0johntam0o - o0johntam0o@gmail.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class acp_archive_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_archive',
			'title'		=> 'ARCHIVE_TITLE_ACP',
			'version'	=> '1.1.4',
			'modes'		=> array(
				'index'	=> array(
					'title'			=> 'ARCHIVE_TITLE_ACP',
					'auth'			=> 'acl_a_board',
					'cat'			=> array('ARCHIVE_TITLE_ACP'),
				),
			),
		);
	}
}

?>