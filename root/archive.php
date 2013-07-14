<?php
/**
*
* @package Forum Archive II
* @version 1.1.4 of 14.07.2013
* @copyright (c) 2012 o0johntam0o - o0johntam0o@gmail.com
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

$user->session_begin();
$auth->acl($user->data);
$user->setup('common');
$user->setup('mods/archive');

// DECLARE THE GLOBAL VARIABLES
$pageview_t = request_var('t', 0);
$pageview_f = request_var('f', 0);
$pageview_page = request_var('page', 0);

$archive_enable = isset($config['archive_enable']) ? $config['archive_enable'] : 0;
$topics_per_page = isset($config['archive_topics_per_page']) ? $config['archive_topics_per_page'] : 15;
$posts_per_page = isset($config['archive_posts_per_page']) ? $config['archive_posts_per_page'] : 10;
$hide_mod = isset($config['archive_hide_mod']) ? $config['archive_hide_mod'] : 1;

/**
*	INPUT
*		$id = forum_id
*	
*	RETURN
*		If ($id > 0)	return login state
*/
function check_forum_login($id = 0, $pass = '')
{
	if ($id > 0)
	{
		global $db, $user, $template, $phpEx;

		$id = (int) $id;
		
		$pass_input = utf8_normalize_nfc(request_var('password', '', true));

		$sql = 'SELECT forum_id
			FROM ' . FORUMS_ACCESS_TABLE . '
			WHERE forum_id = ' . $id . '
				AND user_id = ' . $user->data['user_id'] . "
				AND session_id = '" . $db->sql_escape($user->session_id) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($row)
		{
			return true;
		}

		if ($pass_input)
		{
			// Remove expired authorised sessions
			$sql = 'SELECT f.session_id
				FROM ' . FORUMS_ACCESS_TABLE . ' f
				LEFT JOIN ' . SESSIONS_TABLE . ' s ON (f.session_id = s.session_id)
				WHERE s.session_id IS NULL';
			$result = $db->sql_query($sql);

			if ($row = $db->sql_fetchrow($result))
			{
				$sql_in = array();
				do
				{
					$sql_in[] = (string) $row['session_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				// Remove expired sessions
				$sql = 'DELETE FROM ' . FORUMS_ACCESS_TABLE . '
					WHERE ' . $db->sql_in_set('session_id', $sql_in);
				$db->sql_query($sql);
			}
			$db->sql_freeresult($result);

			if (phpbb_check_hash($pass_input, $pass))
			{
				$sql_ary = array(
					'forum_id'		=> $id,
					'user_id'		=> (int) $user->data['user_id'],
					'session_id'	=> (string) $user->session_id,
				);

				$db->sql_query('INSERT INTO ' . FORUMS_ACCESS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));

				return true;
			}

			$template->assign_var('ARCHIVE_LOGIN_ERROR', $user->lang['WRONG_PASSWORD']);
		}

		$template->assign_vars(array(
			'S_ARCHIVE_LOGIN_ACTION'		=> build_url(array('f')),
			'S_ARCHIVE_HIDDEN_FIELDS'		=> build_hidden_fields(array('f' => $id)))
		);
		return false;
	}
	return false;
}


/**
*	INPUT
*		$id = parent_id
*	
*	RETURN
*		If ($id > 0)	return array(forum_id => forum_name)
*		Else			return array(forum_id => array(forum_name => parent_id))
*/
function fetch_forum_list($id = 0)
{
	global $db, $template;
	
	$id = (int)$id;
	
	// Check if forum is protected
	if ($id > 0)
	{
		$result = $db->sql_query('SELECT f.forum_password
								FROM ' . FORUMS_TABLE . ' f' . "
								WHERE f.forum_id = $id");
		$check_pass = $db->sql_fetchrow($result);
		$check_pass = $check_pass['forum_password'];
		$db->sql_freeresult($result);
		
		if (isset($check_pass) && $check_pass != '' && !check_forum_login($id, $check_pass))
		{
			$template->assign_var('ARCHIVE_FORUM_PROTECTED', true);
			return;
		}
	}
	
	$archive_sql = array(
		'FROM'		=> array(FORUMS_TABLE => 'f'),
		'ORDER_BY'	=> 'f.left_id ASC'
		);
	if ($id > 0)
	{
		$archive_sql['SELECT']	= 'f.forum_id, f.forum_name';
		$archive_sql['WHERE']	= "f.parent_id = $id";
	}
	else
	{
		$archive_sql['SELECT']	= 'f.forum_id, f.parent_id, f.forum_name';
	}
	$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
	while ($row = $db->sql_fetchrow($result))
	{
		if ($id > 0)
		{
			$_fetch_forum_list[$row['forum_id']] = $row['forum_name'];
		}
		else
		{
			$_fetch_forum_list[$row['forum_id']][$row['forum_name']] = $row['parent_id'];
		}
	}
	$db->sql_freeresult($result);
	if (isset($_fetch_forum_list))
	{
		return $_fetch_forum_list;
	}
}


/**
*	INPUT
*		$id		= forum_id
*		$limit	= Limitation of rows
*		$start	= Position of row
*	
*	RETURN
*		If ($id > 0)	return array(topic_id => topic_title)
*/
function fetch_topic_list($id = 0, $limit = 0, $start = 0)
{
	if ($id > 0)
	{
		global $db, $auth, $template;
		
		$id = (int)$id;
		$limit = (int)$limit;
		$start = (int)$start;
	
		// Check if forum is protected
		$result = $db->sql_query('SELECT f.forum_password
								FROM ' . FORUMS_TABLE . ' f' . "
								WHERE f.forum_id = $id");
		$check_pass = $db->sql_fetchrow($result);
		$check_pass = $check_pass['forum_password'];
		$db->sql_freeresult($result);
		
		if (isset($check_pass) && $check_pass != '' && !check_forum_login($id, $check_pass))
		{
			$template->assign_var('ARCHIVE_FORUM_PROTECTED', true);
			return;
		}
		
		if ($limit == 0 && $start == 0)
		{
			// For count
			$tmp_sql = 'SELECT forum_topics_real, forum_topics FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $id;
			$result = $db->sql_query($tmp_sql);
			$topic_count = (int) (($auth->acl_get('m_approve', $id)) ? $db->sql_fetchfield('forum_topics_real') : $db->sql_fetchfield('forum_topics'));
			$db->sql_freeresult($result);
			return $topic_count;
		}

		$archive_sql = array(
			'SELECT'	=> 't.topic_id, t.topic_title',
			'FROM'		=> array(TOPICS_TABLE => 't')
			);
		// Fetch Global Announcements
		$archive_sql['WHERE']		= 't.topic_type = ' . POST_GLOBAL;
		$archive_sql['WHERE']		.= ($auth->acl_get('m_approve', $id)) ? '' : ' AND t.topic_approved = 1';
		$archive_sql['ORDER_BY']	= 't.topic_last_post_time DESC';
		$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_topic_list[$row['topic_id']] = $row['topic_title'];
		}
		$db->sql_freeresult($result);
		// Fetch Announcements And Sticky
		$archive_sql['WHERE'] = "t.forum_id = $id AND " . $db->sql_in_set('t.topic_type', array(POST_STICKY, POST_ANNOUNCE));
		$archive_sql['WHERE'] .= ($auth->acl_get('m_approve', $id)) ? '' : ' AND t.topic_approved = 1';
		$archive_sql['ORDER_BY'] = 't.topic_type DESC';
		$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_topic_list[$row['topic_id']] = $row['topic_title'];
		}
		$db->sql_freeresult($result);
		// Fetch Normal Topic
		$archive_sql['WHERE'] = "t.forum_id = $id AND t.topic_type = " . POST_NORMAL;
		$archive_sql['WHERE'] .= ($auth->acl_get('m_approve', $id)) ? '' : ' AND t.topic_approved = 1';
		$archive_sql['ORDER_BY'] = 't.topic_last_post_time DESC';
		if ($limit > 0 && $start == 0)
		{
			// For first page
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $limit);
		}
		else if ($limit > 0 && $start > 0)
		{
			// For after pages
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $limit, $start);
		}
		else
		{
			// For after pages - Load default
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $topics_per_page, $start);
		}
		
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_topic_list[$row['topic_id']] = $row['topic_title'];
		}
		$db->sql_freeresult($result);
		
		if (isset($_fetch_topic_list))
		{
			return $_fetch_topic_list;
		}
	}
}


/**
*	INPUT
*		$id			= topic_id
*		$limit		= Limitation of rows
*		$start		= Position of row
*		$forum_id	= forum_id
*	
*	RETURN
*		If ($id > 0 && $forum_id > 0)	return array(post_time => array(poster_id => array(post_subject => post_text)))
*/
function fetch_post_list($id = 0, $limit = 0, $start = 0, $forum_id = 0)
{
	if ($id > 0 && $forum_id > 0)
	{
		global $db, $auth, $template, $user;
		
		$id = (int)$id;
		$limit = (int)$limit;
		$start = (int)$start;
		$forum_id = (int)$forum_id;
	
		// Check if forum is protected
		$result = $db->sql_query('SELECT f.forum_password
								FROM ' . FORUMS_TABLE . ' f' . "
								WHERE f.forum_id = $forum_id");
		$check_pass = $db->sql_fetchrow($result);
		$check_pass = $check_pass['forum_password'];
		$db->sql_freeresult($result);
		
		if (isset($check_pass) && $check_pass != '' && !check_forum_login($forum_id, $check_pass))
		{
			$template->assign_var('ARCHIVE_FORUM_PROTECTED', true);
			return;
		}
		
		if ($limit == 0 && $start == 0)
		{
			// For count
			$tmp_sql = 'SELECT topic_replies, topic_replies_real FROM ' . TOPICS_TABLE . ' WHERE topic_id = ' . $id;
			$result = $db->sql_query($tmp_sql);
			$post_count = (int) (($auth->acl_get('m_approve', $id)) ? $db->sql_fetchfield('topic_replies_real') : $db->sql_fetchfield('topic_replies'));
			$post_count = $post_count + 1;
			$db->sql_freeresult($result);
			return $post_count;
		}
		
		$archive_sql = array(
			'SELECT'	=> 'p.post_subject, p.post_text, p.poster_id, p.post_time',
			'FROM'		=> array(POSTS_TABLE => 'p')
			);
		$archive_sql['WHERE'] = "p.topic_id = $id";
		$archive_sql['WHERE'] .= ($auth->acl_get('m_approve', $forum_id)) ? '' : ' AND p.post_approved = 1';
		$archive_sql['ORDER_BY'] = 'p.post_time ASC';
		if ($limit > 0 && $start == 0)
		{
			// For first page
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $limit);
		}
		else if ($limit > 0 && $start > 0)
		{
			// For after pages
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $limit, $start);
		}
		else
		{
			// For after pages - Load default
			$result = $db->sql_query_limit($db->sql_build_query('SELECT', $archive_sql), $posts_per_page, $start);
		}
		
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_post_list[$row['post_time']][$row['poster_id']] = array($row['post_subject'] => $row['post_text']);
		}
		$db->sql_freeresult($result);
		
		if (isset($_fetch_post_list))
		{
			// Update topic view
			if (isset($user->data['session_page']) && !$user->data['is_bot'] && (strpos($user->data['session_page'], '&t=' . $id) === false || isset($user->data['session_created'])))
			{
				$sql = 'UPDATE ' . TOPICS_TABLE . '
					SET topic_views = topic_views + 1, topic_last_view_time = ' . time() . "
					WHERE topic_id = $id";
				$db->sql_query($sql);
			}
			
			return $_fetch_post_list;
		}
	}
}


/**
*	INPUT
*		$id = user_id
*	
*	RETURN
*		If ($id > 0)	return username
*/
function fetch_username($id)
{
	if ($id > 0)
	{
		global $db;
		$id = (int)$id;
		$archive_sql = array(
			'SELECT'	=> 'u.username',
			'FROM'		=> array(USERS_TABLE => 'u'),
			'WHERE'		=> "u.user_id = $id"
			);
		$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_username = $row['username'];
		}
		$db->sql_freeresult($result);
		if (isset($_fetch_username))
		{
			return $_fetch_username;
		}
	}
}	


/**
*	INPUT
*		$id = topic_id
*	
*	RETURN
*		If ($id > 0)	return topic_title
*/
function fetch_topic_title($id)
{
	if ($id > 0)
	{
		global $db;
		$id = (int)$id;
		$archive_sql = array(
			'SELECT'	=> 't.topic_title',
			'FROM'		=> array(TOPICS_TABLE => 't'),
			'WHERE'		=> "t.topic_id = $id"
			);
		$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_topic_title = $row['topic_title'];
		}
		$db->sql_freeresult($result);
		if (isset($_fetch_topic_title))
		{
			return $_fetch_topic_title;
		}
	}
}


/**
*	INPUT
*		$id = forum_id
*	
*	RETURN
*		If ($id > 0)	return forum_name
*/
function fetch_forum_name($id)
{
	if ($id > 0)
	{
		global $db;
		$id = (int)$id;
		$archive_sql = array(
			'SELECT'	=> 'f.forum_name',
			'FROM'		=> array(FORUMS_TABLE => 'f'),
			'WHERE'		=> "f.forum_id = $id"
			);
		$result = $db->sql_query($db->sql_build_query('SELECT', $archive_sql));
		while ($row = $db->sql_fetchrow($result))
		{
			$_fetch_forum_name = $row['forum_name'];
		}
		$db->sql_freeresult($result);
		if (isset($_fetch_forum_name))
		{
			return $_fetch_forum_name;
		}
	}
}


/**
*	INPUT
*		$id			= forum_id
*		$arr		= array(forum_id => array(forum_name => parent_id))
*	
*	RETURN
*		If (is_array($arr))		return array()		(Branches)
*/
function count_sub_level($id, $arr)
{
	if (is_array($arr))
	{
		$id = (int)$id;
		$count[1] = $id;
		while ($id != 0)
		{
			foreach ($arr as $key => $value)
			{
				if ($key == $id)
				{
					$id = array_shift($value);
					$count[] = $id;
					break;
				}
			}
		}
		return $count;
	}
}


// BEGIN PROCESSING

if ($pageview_f == 0 && $archive_enable)
{
	// ------ MAKE MAIN FORUMS OR CATEGORIES
	$_fetch_forum_list = fetch_forum_list();
	if (is_array($_fetch_forum_list))
	{
		$template->assign_var('ARCHIVE_AVAILABLE', true);
		foreach ($_fetch_forum_list as $id => $arr)
		{
			if ($auth->acl_get('f_list', $id))
			{
				foreach ($arr as $name => $parent)
				{
					$template->assign_block_vars('archive_row', array(
						'ARCHIVE_ROW_FORUM'		=> true,
						'ARCHIVE_ROW_LEVEL'		=> sizeof(count_sub_level($parent, $_fetch_forum_list)),
						'ARCHIVE_FORUMS_NAME'	=> $name,
						'ARCHIVE_FORUMS_LINK'	=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $id),
						));
				}
			}
		}
	}
	unset($_fetch_forum_list);
	$template->assign_vars(array(
		'U_MCP'		=> ($auth->acl_get('m_') || $auth->acl_getf_global('m_')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=main&amp;mode=front') : '',
		));
}
else if ($pageview_f > 0 && $archive_enable)
{
	$template->assign_var('ARCHIVE_TITLE_FORUM', fetch_forum_name($pageview_f));
	// ------ MAKE THE PARENTS MENU
	$_fetch_forum_list = fetch_forum_list();
	if (is_array($_fetch_forum_list))
	{
		foreach ($_fetch_forum_list as $id => $arr)
		{
			foreach ($arr as $name => $parent)
			{
				if ($id == $pageview_f)
				{
					$parent_link = count_sub_level($id, $_fetch_forum_list);
					if (sizeof($parent_link) > 1)
					{
						$template->assign_var('ARCHIVE_ROW_PARENT', true);
						for ($i = sizeof($parent_link) - 1; $i > 0; $i--)
						{
							if ($auth->acl_get('f_list', $parent_link[$i]))
							{
								$template->assign_block_vars('archive_row_parent', array(
									'ARCHIVE_ROW_PARENT_NAME'		=> fetch_forum_name($parent_link[$i]),
									'ARCHIVE_ROW_PARENT_LINK'		=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $parent_link[$i]),
									'ARCHIVE_ROW_PARENT_LINK_FULL'	=> append_sid("{$phpbb_root_path}viewforum.$phpEx", 'f=' . $parent_link[$i]),
								));
							}
						}
					}
					unset($parent_link);
				}
			}
		}
	}
	unset($_fetch_forum_list);
	if ($pageview_t == 0)
	{
		// ------ MAKE PAGE NUMBER FOR TOPICS
		if ($auth->acl_get('f_read', $pageview_f))
		{
			$count_topics = fetch_topic_list($pageview_f);
			if ($count_topics > $topics_per_page)
			{
				$count_pages = $count_topics / $topics_per_page;
				if ($count_pages > (int)$count_pages)
				{
					$count_pages = (int)$count_pages + 1;
				}
				for ($i = 1; $i <= $count_pages; $i++)
				{
					$template->assign_var('ARCHIVE_PAGE_COUNT', true);
					if ($pageview_page == $i || ($pageview_page == 0 && $i == 1))
					{
						$template->assign_var('ARCHIVE_TOPIC_PAGE', $i);
						$template->assign_block_vars('archive_page', array(
							'ARCHIVE_PAGE_NUM'	=> $i,
							'ARCHIVE_PAGE_LINK'	=> 0,
							));
					}
					else
					{
						$template->assign_block_vars('archive_page', array(
							'ARCHIVE_PAGE_NUM'	=> $i,
							'ARCHIVE_PAGE_LINK'	=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $pageview_f . '&amp;page=' . $i),
							));
					}
				}
			}
			unset($count_pages);
			unset($count_topics);
		}
		
		// ------ MAKE FORUM LIST IN THIS FORUM OR CATEGORY
		$_fetch_forum_list = fetch_forum_list($pageview_f);
		if (is_array($_fetch_forum_list))
		{
			$template->assign_var('ARCHIVE_AVAILABLE', true);
			foreach ($_fetch_forum_list as $id => $name)
			{
				if ($auth->acl_get('f_list', $id))
				{
					$template->assign_block_vars('archive_row', array(
						'ARCHIVE_ROW_FORUM'		=> true,
						'ARCHIVE_ROW_LEVEL'		=> 1,
						'ARCHIVE_FORUMS_NAME'	=> $name,
						'ARCHIVE_FORUMS_LINK'	=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $id),
						));
				}
			}
		}
		unset($_fetch_forum_list);
		
		// ------ MAKE TOPIC LIST IN THIS FORUM OR CATEGORY
		if ($auth->acl_get('f_read', $pageview_f))
		{
			if ($pageview_page > 1)
			{
				$_fetch_topic_list = fetch_topic_list($pageview_f, $topics_per_page, ($pageview_page - 1) * $topics_per_page);
			}
			else
			{
				$_fetch_topic_list = fetch_topic_list($pageview_f, $topics_per_page);
			}
			if (is_array($_fetch_topic_list))
			{
				$template->assign_var('ARCHIVE_AVAILABLE', true);
				foreach ($_fetch_topic_list as $id => $title)
				{
					$template->assign_block_vars('archive_row', array(
						'ARCHIVE_ROW_FORUM'		=> false,
						'ARCHIVE_TOPICS_NAME'	=> $title,
						'ARCHIVE_TOPICS_LINK'	=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $pageview_f . '&amp;t=' . $id),
						));
				}
				$template->assign_vars(array(
					'U_MCP'		=> ($auth->acl_get('m_', $pageview_f)) ? append_sid("{$phpbb_root_path}mcp.$phpEx", "i=main&amp;mode=forum_view&amp;f=$pageview_f") : '',
					));
			}
			unset($_fetch_topic_list);
		}
	}
	else if ($pageview_t > 0 && $auth->acl_get('f_read', $pageview_f))	// FETCH TOPIC BODY
	{
		// ------ MAKE PAGE NUMBER FOR POSTS
		$count_posts = fetch_post_list($pageview_t, 0, 0, $pageview_f);
		if ($count_posts > $posts_per_page)
		{
			$count_pages = $count_posts / $posts_per_page;
			if ($count_pages > (int)$count_pages)
			{
				$count_pages = (int)$count_pages + 1;
			}
			for ($i = 1; $i <= $count_pages; $i++)
			{
				$template->assign_var('ARCHIVE_PAGE_COUNT', true);
				if ($pageview_page == $i || ($pageview_page == 0 && $i == 1))
				{
					$template->assign_var('ARCHIVE_POST_PAGE', $i);
					$template->assign_block_vars('archive_page', array(
						'ARCHIVE_PAGE_NUM'	=> $i,
						'ARCHIVE_PAGE_LINK'	=> 0,
						));
				}
				else
				{
					$template->assign_block_vars('archive_page', array(
						'ARCHIVE_PAGE_NUM'	=> $i,
						'ARCHIVE_PAGE_LINK'	=> append_sid("{$phpbb_root_path}archive.$phpEx", 'f=' . $pageview_f . '&amp;t=' . $pageview_t . '&amp;page=' . $i),
						));
				}
			}
		}
		unset($count_pages);
		unset($count_posts);
		
		// ------ MAKE POST LIST IN THIS FORUM
		$template->assign_var('ARCHIVE_TITLE_TOPIC', fetch_topic_title($pageview_t));
		if ($pageview_page > 1)
		{
			$_fetch_post_list = fetch_post_list($pageview_t, $posts_per_page, ($pageview_page - 1) * $posts_per_page, $pageview_f);
		}
		else
		{
			$_fetch_post_list = fetch_post_list($pageview_t, $posts_per_page, 0, $pageview_f);
		}
		if (is_array($_fetch_post_list))
		{
			$template->assign_var('ARCHIVE_AVAILABLE', true);
			$template->assign_vars(array(
				'ARCHIVE_POST_AVAILABLE'	=> true,
				'ARCHIVE_TOPIC_LINK_FULL'	=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'f=' . $pageview_f . '&amp;t=' . $pageview_t),
				'ARCHIVE_TOPIC_NAME'		=> fetch_topic_title($pageview_t),
				));
			foreach($_fetch_post_list as $time => $author_subject_text)
			{
				foreach ($author_subject_text as $author => $subject_text)
				{
					foreach ($subject_text as $subject => $text)
					{
						if ($user->data['user_id'] == ANONYMOUS || $user->data['is_bot'])
						{
							if ($hide_mod)
							{
								// For BBCode [Hidden] from guest
								$text = preg_replace('#\[Hidden:.{8}\].*\[/Hidden:.{8}\]#i', '', $text);
								// For BBCode [Hide] from guest
								$text = preg_replace('#\[Hide:.{8}\].*\[/Hide:.{8}\]#i', '', $text);
							}
						}
						
						strip_bbcode($text);
						$text = bbcode_nl2br($text);
						$template->assign_block_vars('archive_post', array(
								'ARCHIVE_POST_AUTHOR'		=> fetch_username($author),
								'ARCHIVE_POST_TIME'			=> $user->format_date($time, false, true),
								'ARCHIVE_POST_SUBJECT'		=> $subject,
								'ARCHIVE_POST_TEXT'			=> $text,
							));
					}
				}
			}
			$template->assign_vars(array(
				'U_MCP' 	=> ($auth->acl_get('m_', $pageview_f)) ? append_sid("{$phpbb_root_path}mcp.$phpEx", "i=main&amp;mode=topic_view&amp;f=$pageview_f&amp;t=$pageview_t") : '',
				));
		}
	}
}

$template->assign_vars(array(
	'ARCHIVE_LINK_HOME'			=> append_sid("{$phpbb_root_path}archive.$phpEx"),
	'ARCHIVE_LINK_HOME_FULL'	=> append_sid("{$phpbb_root_path}index.$phpEx"),
	));

page_header();

$template->set_filenames(array(
		'body' => 'mods/archive.html'
	));

page_footer();

?>