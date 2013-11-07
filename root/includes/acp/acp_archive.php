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
* @package acp
*/
class acp_archive
{
	var $u_action;
	
	function main($id, $mode)
	{
		global $user, $template, $config;

		$this->tpl_name = 'acp_archive';
		$this->page_title = $user->lang['ARCHIVE_TITLE_ACP'];

		$form_name = 'acp_archive';
		add_form_key($form_name);

		$submit = isset($_POST['submit']) ? true : false;

		if ($submit)
		{
			if (!check_form_key($form_name))
			{
				trigger_error('FORM_INVALID');
			}
			
			set_config('archive_enable', request_var('archive_enable', 0));
			set_config('archive_topics_per_page', request_var('archive_topics_per_page', 15));
			set_config('archive_posts_per_page', request_var('archive_posts_per_page', 10));
			set_config('archive_hide_mod', request_var('archive_hide_mod', 1));
			
			add_log('admin', 'ARCHIVE_LOG_MSG');
			trigger_error($user->lang['ARCHIVE_SAVED'] . adm_back_link($this->u_action));
		}
		
		$template->assign_vars(array(
			'U_ACTION'						=> $this->u_action,
			'S_ARCHIVE_VERSION'				=> isset($config['archive_version']) ? $config['archive_version'] : false,
			'S_ARCHIVE_ENABLE'				=> isset($config['archive_enable']) ? $config['archive_enable'] : 0,
			'S_ARCHIVE_TOPICS_PER_PAGE'		=> isset($config['archive_topics_per_page']) ? $config['archive_topics_per_page'] : 15,
			'S_ARCHIVE_POSTS_PER_PAGE'		=> isset($config['archive_posts_per_page']) ? $config['archive_posts_per_page'] : 10,
			'S_ARCHIVE_HIDE_MOD'			=> isset($config['archive_hide_mod']) ? $config['archive_hide_mod'] : 1,
		));
	}
}
?>
