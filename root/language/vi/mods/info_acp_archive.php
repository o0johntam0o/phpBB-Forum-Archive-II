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
	'ARCHIVE_TITLE_ACP'					=> 'Thiết lập Forum Archive II',
	
	'ARCHIVE_ENABLE'					=> 'Kích hoạt Forum Archive II',
	'ARCHIVE_ENABLE_EXPLAIN'			=> 'Bạn có muốn sử dụng mod này ngay bây giờ?',
	'ARCHIVE_TOPICS_PER_PAGE'			=> 'Số chủ đề mỗi trang',
	'ARCHIVE_TOPICS_PER_PAGE_EXPLAIN'	=> 'Số chủ đề hiển thị ở mỗi trang',
	'ARCHIVE_POSTS_PER_PAGE'			=> 'Số bài viết mỗi trang',
	'ARCHIVE_POSTS_PER_PAGE_EXPLAIN'	=> 'Số bài viết hiển thị ở mỗi trang',
	'ARCHIVE_HIDE_MOD'					=> 'Hide/Hidden MOD',
	'ARCHIVE_HIDE_MOD_EXPLAIN'			=> 'Bạn có đang sử dụng MOD dùng BBCode [Hide] hoặc [Hidden] để ẩn nội dung bài viết không',
	'ARCHIVE_ADDITIONAL_CODE'			=> 'Mã thêm vào',
	'ARCHIVE_ADDITIONAL_CODE_EXPLAIN'	=> 'Chèn thêm mã vào thẻ HEAD<br />Ví dụ: &lt;script type=&quot;text/javascript&quot;&gt;alert(&quot;Blah!&quot;);&lt;/script&gt;<br />&lt;link href=&quot;myStyle.css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot; /&gt;<br />...',
	'ARCHIVE_CUSTOM_STYLE'				=> 'Sử dụng giao diện tùy chỉnh',
	'ARCHIVE_CUSTOM_STYLE_EXPLAIN'		=> 'Để chỉnh sửa giao diện của trang lưu trữ',
	'ARCHIVE_CUSTOM_STYLE_EXPLAIN2'		=> 'Ví dụ: #000000,... hoặc blue,...<br />Bỏ trống để trả về giá trị mặc định',
	'ARCHIVE_STYLE_BG_MAIN'				=> 'Màu nền chính',
	'ARCHIVE_STYLE_BG_HEADER'			=> 'Màu nền phần tiêu đề',
	'ARCHIVE_STYLE_BG_BODY'				=> 'Màu nền phần nội dung',
	'ARCHIVE_STYLE_BG_FOOTER'			=> 'Màu nền phần cuối',
	'ARCHIVE_STYLE_BG_POSTS'			=> 'Màu nền các bài viết',
	'ARCHIVE_STYLE_COLOR_COMMON'		=> 'Màu chữ (chung)',
	'ARCHIVE_STYLE_COLOR_COMMON_LINK'	=> 'Màu liên kết (chung)',
	'ARCHIVE_STYLE_COLOR_COMMON_VLINK'	=> 'Màu liên kết đã truy cập (chung)',
	'ARCHIVE_STYLE_COLOR_HEADER'		=> 'Màu chữ (phần tiêu đề)',
	'ARCHIVE_STYLE_COLOR_HEADER_LINK'	=> 'Màu liên kết (phần tiêu đề)',
	'ARCHIVE_STYLE_COLOR_HEADER_VLINK'	=> 'Màu liên kết đã truy cập (phần tiêu đề)',
	'ARCHIVE_STYLE_COLOR_TITLE'			=> 'Tiêu đề bài viết',
	'ARCHIVE_STYLE_COLOR_AUTHOR'		=> 'Tên người gửi',
	
	'ARCHIVE_SAVED'						=> 'Các thiết lập cho Forum Archive II đã được cập nhật',
	'ARCHIVE_LOG_MSG'					=> '<strong>Đã thay đổi các thiết lập của Forum Archive II</strong>',
));

?>