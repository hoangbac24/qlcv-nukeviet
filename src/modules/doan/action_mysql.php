<?php

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

/**
 * Module Do An - Install Database
 */

$sql_create_module = [];

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . " (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    ten varchar(255) NOT NULL,
    mo_ta text,
    addtime int(11) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (id)
) ENGINE=MyISAM";

?>