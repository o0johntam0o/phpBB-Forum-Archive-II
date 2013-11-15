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
	'ARCHIVE_TITLE_ACP'					=> 'Thiết lập Forum Archive II',
	
	'ARCHIVE_ENABLE'					=> 'Kích hoạt Forum Archive II',
	'ARCHIVE_ENABLE_EXPLAIN'			=> 'Bạn có muốn sử dụng mod này ngay bây giờ?',
	'ARCHIVE_TOPICS_PER_PAGE'			=> 'Số chủ đề mỗi trang',
	'ARCHIVE_TOPICS_PER_PAGE_EXPLAIN'	=> 'Số chủ đề hiển thị ở mỗi trang',
	'ARCHIVE_POSTS_PER_PAGE'			=> 'Số bài viết mỗi trang',
	'ARCHIVE_POSTS_PER_PAGE_EXPLAIN'	=> 'Số bài viết hiển thị ở mỗi trang',
	'ARCHIVE_HIDE_MOD'					=> 'Hide/Hidden MOD',
	'ARCHIVE_HIDE_MOD_EXPLAIN'			=> 'Bạn có đang sử dụng MOD dùng BBCode [Hide] hoặc [Hidden] để ẩn nội dung bài viết không',
	
	'ARCHIVE_SAVED'						=> 'Các thiết lập cho Forum Archive II đã được cập nhật',
	'ARCHIVE_LOG_MSG'					=> '<strong>Đã thay đổi các thiết lập của Forum Archive II</strong>',
));

?>
