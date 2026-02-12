<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_ADMIN') || !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'My Jobs',
    'modfuncs' => 'main,detail',
    'adminfuncs' => 'main,categories,add,edit,delete,add_cat,edit_cat,delete_cat',
    'submenu' => 'main,categories',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '1.0.0',
    'date' => '2026-02-11',
    'author' => 'Antigravity',
    'note' => '',
    'admin' => 1
];
