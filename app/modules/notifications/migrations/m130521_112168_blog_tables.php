<?php

class m130521_112168_blog_tables extends \yii\db\Migration
{

    public function safeUp()
    {
        $sql = <<< EOD
DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE IF NOT EXISTS `notification_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED,
  `setting_id` INT(11) UNSIGNED,
  `value` tinyint(1) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `setting_id_idx` (`setting_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `notification_last_news`;
CREATE TABLE IF NOT EXISTS `notification_last_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED,
  `post_id` INT(11) UNSIGNED,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id_idx` (`post_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `notification_types`;
CREATE TABLE IF NOT EXISTS `notification_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO `notification_types` (`id`, `type`) VALUES
(1, 'email'), (2, 'browser');

EOD;
        $this->execute($sql);
    }

    public function down()
    {
        
    }
}