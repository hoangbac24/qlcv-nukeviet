<?php

if (!defined('NV_IS_ADMIN')) {
    die('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_file . '/admin.functions.php';

$op = $nv_Request->get_title('op', 'get', 'main');

if (!in_array($op, $allow_func)) {
    $op = 'main';
}

require NV_ROOTDIR . '/modules/' . $module_file . '/admin/' . $op . '.php';