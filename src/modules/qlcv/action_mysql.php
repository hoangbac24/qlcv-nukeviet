<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_tasks;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_categories;';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_categories (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 description text,
 weight smallint(4) unsigned NOT NULL DEFAULT 0,
 add_time int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (id)
) ENGINE=MyISAM';

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_tasks (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 catid mediumint(8) unsigned NOT NULL DEFAULT 0,
 title varchar(250) NOT NULL,
 description text,
 status tinyint(1) unsigned NOT NULL DEFAULT 0,
 add_time int(11) NOT NULL DEFAULT 0,
 edit_time int(11) NOT NULL DEFAULT 0,
 checkin_image varchar(255) DEFAULT "",
 checkout_image varchar(255) DEFAULT "",
 report_file varchar(255) DEFAULT "",
 PRIMARY KEY (id),
 KEY catid (catid)
) ENGINE=MyISAM';
