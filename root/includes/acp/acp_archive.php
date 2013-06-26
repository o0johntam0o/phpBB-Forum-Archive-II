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


/**
* @package acp
*/
class acp_archive
{
	var $u_action;
	
	function main($id, $mode)
	{
		global $user, $template, $config;
		
		// Default colors
		$archive_style_bg_main_default = '#663300';
		$archive_style_bg_header_default = '#dcdcdc';
		$archive_style_bg_body_default = '#eeeeee';
		$archive_style_bg_footer_default = '#dcdcdc';
		$archive_style_bg_posts_default = '#ffffff';
					
		$archive_style_color_common_default = '#000000';
		$archive_style_color_common_link_default = '#0000ff';
		$archive_style_color_common_vlink_default = '#800080';
		$archive_style_color_header_default = '#ff0000';
		$archive_style_color_header_link_default = '#0000ff';
		$archive_style_color_header_vlink_default = '#0000ff';
		$archive_style_color_title_default = '#0000ff';
		$archive_style_color_author_default = '#d23d24';

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
			set_config('archive_additional_code', utf8_normalize_nfc(request_var('archive_additional_code', '', true)));
			set_config('archive_custom_style', request_var('archive_custom_style', 0));
			
			// Background
			$tmp = request_var('archive_style_bg_main', $archive_style_bg_main_default);
			$tmp = ($tmp == '') ? $archive_style_bg_main_default : $tmp;
			set_config('archive_style_bg_main', $tmp);
			
			$tmp = request_var('archive_style_bg_header', $archive_style_bg_header_default);
			$tmp = ($tmp == '') ? $archive_style_bg_header_default : $tmp;
			set_config('archive_style_bg_header', $tmp);
			
			$tmp = request_var('archive_style_bg_body', $archive_style_bg_body_default);
			$tmp = ($tmp == '') ? $archive_style_bg_body_default : $tmp;
			set_config('archive_style_bg_body', $tmp);
			
			$tmp = request_var('archive_style_bg_footer', $archive_style_bg_footer_default);
			$tmp = ($tmp == '') ? $archive_style_bg_footer_default : $tmp;
			set_config('archive_style_bg_footer', $tmp);
			
			$tmp = request_var('archive_style_bg_posts', $archive_style_bg_posts_default);
			$tmp = ($tmp == '') ? $archive_style_bg_posts_default : $tmp;
			set_config('archive_style_bg_posts', $tmp);
			
			// Font color
			$tmp = request_var('archive_style_color_common', $archive_style_color_common_default);
			$tmp = ($tmp == '') ? $archive_style_color_common_default : $tmp;
			set_config('archive_style_color_common', $tmp);
			
			$tmp = request_var('archive_style_color_common_link', $archive_style_color_common_link_default);
			$tmp = ($tmp == '') ? $archive_style_color_common_link_default : $tmp;
			set_config('archive_style_color_common_link', $tmp);
			
			$tmp = request_var('archive_style_color_common_vlink', $archive_style_color_common_vlink_default);
			$tmp = ($tmp == '') ? $archive_style_color_common_vlink_default : $tmp;
			set_config('archive_style_color_common_vlink', $tmp);
			
			$tmp = request_var('archive_style_color_header', $archive_style_color_header_default);
			$tmp = ($tmp == '') ? $archive_style_color_header_default : $tmp;
			set_config('archive_style_color_header', $tmp);
			
			$tmp = request_var('archive_style_color_header_link', $archive_style_color_header_link_default);
			$tmp = ($tmp == '') ? $archive_style_color_header_link_default : $tmp;
			set_config('archive_style_color_header_link', $tmp);
			
			$tmp = request_var('archive_style_color_header_vlink', $archive_style_color_header_vlink_default);
			$tmp = ($tmp == '') ? $archive_style_color_header_vlink_default : $tmp;
			set_config('archive_style_color_header_vlink', $tmp);
			
			$tmp = request_var('archive_style_color_title', $archive_style_color_title_default);
			$tmp = ($tmp == '') ? $archive_style_color_title_default : $tmp;
			set_config('archive_style_color_title', $tmp);
			
			$tmp = request_var('archive_style_color_author', $archive_style_color_author_default);
			$tmp = ($tmp == '') ? $archive_style_color_author_default : $tmp;
			set_config('archive_style_color_author', $tmp);
			
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
			'S_ARCHIVE_ADDITIONAL_CODE'		=> isset($config['archive_additional_code']) ? $config['archive_additional_code'] : '',
			
			'S_ARCHIVE_CUSTOM_STYLE'		=> isset($config['archive_custom_style']) ? $config['archive_custom_style'] : 0,
			'S_ARCHIVE_STYLE_BG_MAIN'		=> isset($config['archive_style_bg_main']) ? $config['archive_style_bg_main'] : $archive_style_bg_main_default,
			'S_ARCHIVE_STYLE_BG_HEADER'		=> isset($config['archive_style_bg_header']) ? $config['archive_style_bg_header'] : $archive_style_bg_header_default,
			'S_ARCHIVE_STYLE_BG_BODY'		=> isset($config['archive_style_bg_body']) ? $config['archive_style_bg_body'] : $archive_style_bg_body_default,
			'S_ARCHIVE_STYLE_BG_FOOTER'		=> isset($config['archive_style_bg_footer']) ? $config['archive_style_bg_footer'] : $archive_style_bg_footer_default,
			'S_ARCHIVE_STYLE_BG_POSTS'		=> isset($config['archive_style_bg_posts']) ? $config['archive_style_bg_posts'] : $archive_style_bg_posts_default,
			
			'S_ARCHIVE_STYLE_COLOR_COMMON'			=> isset($config['archive_style_color_common']) ? $config['archive_style_color_common'] : $archive_style_color_common_default,
			'S_ARCHIVE_STYLE_COLOR_COMMON_LINK'		=> isset($config['archive_style_color_common_link']) ? $config['archive_style_color_common_link'] : $archive_style_color_common_link_default,
			'S_ARCHIVE_STYLE_COLOR_COMMON_VLINK'	=> isset($config['archive_style_color_common_vlink']) ? $config['archive_style_color_common_vlink'] : $archive_style_color_common_vlink_default,
			'S_ARCHIVE_STYLE_COLOR_HEADER'			=> isset($config['archive_style_color_header']) ? $config['archive_style_color_header'] : $archive_style_color_header_default,
			'S_ARCHIVE_STYLE_COLOR_HEADER_LINK'		=> isset($config['archive_style_color_header_link']) ? $config['archive_style_color_header_link'] : $archive_style_color_header_link_default,
			'S_ARCHIVE_STYLE_COLOR_HEADER_VLINK'	=> isset($config['archive_style_color_header_vlink']) ? $config['archive_style_color_header_vlink'] : $archive_style_color_header_vlink_default,
			'S_ARCHIVE_STYLE_COLOR_TITLE'			=> isset($config['archive_style_color_title']) ? $config['archive_style_color_title'] : $archive_style_color_title_default,
			'S_ARCHIVE_STYLE_COLOR_AUTHOR'			=> isset($config['archive_style_color_author']) ? $config['archive_style_color_author'] : $archive_style_color_author_default,
		));
	}
}
?>