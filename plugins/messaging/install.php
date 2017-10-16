<?php
$CI = get_instance();
$db = $CI->db;
$db->query("ALTER TABLE  `tblstaff` ADD  `last_active_time` INT NOT NULL AFTER  `email_signature` ;");
$db->query("ALTER TABLE  `tblcontacts` ADD  `last_active_time` INT NOT NULL AFTER  `direction` ;");
$db->query("CREATE TABLE IF NOT EXISTS `tblconversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `is_contact` int(11) NOT NULL DEFAULT '0',
  `last_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;");

$db->query("CREATE TABLE IF NOT EXISTS `tblconversations_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
");

$db->query("CREATE TABLE IF NOT EXISTS `tblconversation_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sticker_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gif_path` int(11) NOT NULL,
  `send_like` int(11) NOT NULL DEFAULT '0',
  `time_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;");

$db->query("CREATE TABLE IF NOT EXISTS `tblconversation_message_read` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=850 ;");

add_option("messaging_can_create_group", 1);
add_option("messaging_chat_opener_color", '#4B5158');
add_option('messaging_chat_head_color','#57B5DF');
add_option('messaging_chat_message_own_color','#57B5DF');\
add_option('messaging_chat_message_own_font_color', '#FFFFFF');
add_option('messaging_chat_message_from_color','#EDEDED');
add_option('messaging_chat_message_from_font_color','#5B5B5B');