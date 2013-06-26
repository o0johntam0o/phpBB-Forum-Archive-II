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
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (!isset($config['archive_enable']) || !$config['archive_enable'])
{
	return;
}

/**
* A hook that is used to change the behavior of phpBB just before the templates
* are displayed.
* @param	phpbb_hook	$hook	the phpBB hook object
* @return	void
*/
function archive_template_hook()
{
	global $template, $phpEx, $phpbb_root_path, $user;
	if (isset($template->_tpldata['.'][0]['U_ARCHIVE_AVAILABLE']))
	{
		return;
	}

	// Don't load hook if not in root path or in archive page.
	if ($user->page['page_dir'] != '' || str_replace('.' . $phpEx, '', $user->page['page_name']) == 'archive')
	{
		return;
	}
	
	$pageview_f = (int) request_var('f', 0);
	$pageview_t = (int) request_var('t', 0);

	$user->add_lang('mods/archive');

	//Standard template variables
	$template->assign_vars(array(
		'U_ARCHIVE_AVAILABLE' 	=> true,
		'U_ARCHIVE_PAGE'		=> ($pageview_f == 0) ? append_sid("{$phpbb_root_path}archive.$phpEx") : append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $pageview_f . (($pageview_t == 0) ? '' : '&amp;t=' . $pageview_t)),
		));
}

// Register
$phpbb_hook->register(array('template', 'display'), 'archive_template_hook');

?>