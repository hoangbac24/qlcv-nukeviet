<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_SYSTEM')) {
    die('Stop!!!');
}

define('NV_IS_MOD_MY_JOBS', true);

require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

$op = $array_op[0] ?? 'main';

switch ($op) {
    case 'detail':
        require_once NV_ROOTDIR . '/modules/' . $module_file . '/funcs/detail.php';
        break;
    default:
        require_once NV_ROOTDIR . '/modules/' . $module_file . '/funcs/main.php';
        break;
}
