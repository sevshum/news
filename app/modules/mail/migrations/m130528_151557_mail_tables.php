<?php

class m130528_151557_mail_tables extends \yii\db\Migration
{

    public function up()
    {
        $sql = <<< EOD
DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_unique_idx` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `mail_template_i18ns`;
CREATE TABLE `mail_template_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_id` varchar(2) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `content_plain` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id_idx` (`parent_id`),
  UNIQUE KEY `lang_id_parent_id_unique_idx` (`lang_id`,`parent_id`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mail_templates` (`id`, `token`, `from`, `from_name`, `bcc`, `created_at`, `updated_at`) VALUES
(1, 'verify_email', 'test@test.com', 'Site support', NULL, '2017-05-11 16:25:45', '2017-05-11 16:25:45'),
(2, 'new_post', 'test@test.com', 'Site support', '', '2017-05-13 10:42:04', '2017-05-13 10:42:04');

INSERT INTO `mail_template_i18ns` (`id`, `lang_id`, `parent_id`, `subject`, `content`, `content_plain`) VALUES
(1, 'en', 1, 'not set', '{email} {username} {link}', NULL),
(2, 'en', 2, 'New Post', '<p>There is {count} new news on {link}</p>', '');
EOD;
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('mail_template_i18ns');
        $this->dropTable('mail_templates');
    }
}