<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_jobs;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_categories;';

$sql_create_module = $sql_drop_module;

// Categories Table
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_categories (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 description text,
 weight smallint(4) unsigned NOT NULL DEFAULT 0,
 add_time int(11) NOT NULL DEFAULT 0,
 edit_time int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (id)
) ENGINE=MyISAM';

// Jobs Table
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_jobs (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 catid mediumint(8) unsigned NOT NULL DEFAULT 0,
 title varchar(250) NOT NULL,
 description text,
 content mediumtext,
 image_checkin varchar(255) DEFAULT \'\',
 image_checkout varchar(255) DEFAULT \'\',
 file_report varchar(255) DEFAULT \'\',
 status tinyint(1) unsigned NOT NULL DEFAULT 1,
 add_time int(11) NOT NULL DEFAULT 0,
 edit_time int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (id),
 KEY catid (catid)
) ENGINE=MyISAM';
