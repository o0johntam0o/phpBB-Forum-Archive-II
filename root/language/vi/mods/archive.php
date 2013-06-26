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
	'ARCHIVE_VIEW'						=> 'Xem bảng lưu trữ của ',
	'ARCHIVE_VIEW_FULL_STORY'			=> '(F)',
	'ARCHIVE_VIEW_FULL_STORY_EXPLAIN'	=> 'Nhấn để xem bản đầy đủ của ',
	'ARCHIVE_BACK'						=> 'Trở về chuyên mục cha',
	'ARCHIVE_BACK_MAIN'					=> 'Trở về khu lưu trữ chính',
	'ARCHIVE_FORUM_PASSWORD'			=> 'Vui lòng nhập mật khẩu để truy cập chuyên mục này',
	'ARCHIVE_NO_FORUM_OR_NO_FORUMS'		=> 'Trang này không tồn tại. Lỗi này có thể xảy ra do:<br />- Diễn đàn này không có chuyên mục nào<br />- Yêu cầu của bạn vừa chọn không hợp lệ<br />- Đây là một chuyên mục liên kết<br />- Archive MOD đã được tắt bởi người quản trị',
	'ARCHIVE_MOD'						=> 'KHU LƯU TRỮ',
	'ARCHIVE_PAGE'						=> 'Trang ',
	'ARCHIVE_JUMP'						=> 'Chuyển đến trang lưu trữ',
));

?>