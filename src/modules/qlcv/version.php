<?php

if (!defined('NV_ADMIN') || !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'QLCV',
    'modfuncs' => 'main,categories,dashboard,search,export,api',
    'adminfuncs' => 'main,categories,add,edit,delete,add_cat,edit_cat,delete_cat',
    'submenu' => '',
    'is_sysmod' => 0,
    'virtual' => 0,
    'version' => '1.0.0',
    'date' => '2026-02-03',
    'author' => 'Test',
    'note' => '',
    'admin' => 1
];
