<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_ADMIN') || !defined('NV_MAINFILE') || !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$allow_func = [
    'main',
    'categories',
    'add',
    'edit',
    'delete',
    'add_cat',
    'edit_cat',
    'delete_cat'
];

$module_upload = $module_name;

define('NV_IS_FILE_ADMIN', true);
