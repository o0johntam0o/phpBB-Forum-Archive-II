<?php
/**
*
* @package Forum Archive II
* @version 1.1.5 of 11.05.2013
* @copyright (c) 2012 o0johntam0o - o0johntam0o@gmail.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

// The name of the mod to be displayed during installation.
$mod_name = 'ARCHIVE_TITLE';

/*
* The name of the config variable which will hold the currently installed version
* UMIL will handle checking, setting, and updating the version itself.
*/
$version_config_name = 'archive_version';

/*
* The language file which will be included when installing
* Language entries that should exist in the language file for UMIL (replace $mod_name with the mod's name you set to $mod_name above)
*/
$language_file = 'mods/info_acp_archive';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/
$versions = array(
	'1.1.5'	=> array(
		// Nothing changed in this version
	),
	
	'1.1.4'	=> array(
		'config_remove' => array(
			array('archive_additional_code'),
			array('archive_custom_style'),
			array('archive_style_bg_main'),
			array('archive_style_bg_header'),
			array('archive_style_bg_body'),
			array('archive_style_bg_footer'),
			array('archive_style_bg_posts'),
			array('archive_style_color_common'),
			array('archive_style_color_common_link'),
			array('archive_style_color_common_vlink'),
			array('archive_style_color_header'),
			array('archive_style_color_header_link'),
			array('archive_style_color_header_vlink'),
			array('archive_style_color_title'),
			array('archive_style_color_author'),
		),
	),
	
	'1.1.3'	=> array(
		'config_add' => array(
			array('archive_additional_code', ''),
		),
	),
	
	'1.1.2'	=> array(
		// Nothing changed in this version
	),
	
	'1.1.1'	=> array(
		// Nothing changed in this version
	),
	
	'1.1.0'	=> array(
		'module_add' => array(
			array('acp', 'ACP_CAT_DOT_MODS', 'ARCHIVE_TITLE'),

			array('acp', 'ARCHIVE_TITLE', array(
					'module_basename'		=> 'archive',
				),
			),
		),
		// Add config value
		'config_add' => array(
			array('archive_enable', 1),
			array('archive_topics_per_page', 15),
			array('archive_posts_per_page', 10),
			array('archive_hide_mod', 1),
			
			array('archive_custom_style', 0),
			array('archive_style_bg_main', '#663300'),
			array('archive_style_bg_header', '#dcdcdc'),
			array('archive_style_bg_body', '#eeeeee'),
			array('archive_style_bg_footer', '#dcdcdc'),
			array('archive_style_bg_posts', '#ffffff'),
			
			array('archive_style_color_common', '#000000'),
			array('archive_style_color_common_link', '#0000ff'),
			array('archive_style_color_common_vlink', '#800080'),
			array('archive_style_color_header', '#ff0000'),
			array('archive_style_color_header_link', '#0000ff'),
			array('archive_style_color_header_vlink', '#0000ff'),
			array('archive_style_color_title', '#0000ff'),
			array('archive_style_color_author', '#d23d24'),
		),
		// Purge the cache
		'cache_purge' => array(),
	),
);

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);


?>