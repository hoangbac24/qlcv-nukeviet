<?php

/**
 * @Project Module Nukeviet 4.x
 * @Author Generated
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 03/02/2026
 */

if (!defined('NV_SYSTEM'))
    die('Stop!!!');

define('NV_IS_MOD_QLCV', true);
$page_config = [];
foreach ($list as $values) {
    $page_config[$values['config_name']] = $values['config_value'];
}

require NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$id = 0;
$page = 1;

if ($page_config['viewtype'] != 2) {
    $alias = (!empty($array_op) and !empty($array_op[0])) ? $array_op[0] : '';
    if (substr($alias, 0, 5) == 'page-') {
        $page = (int) (substr($array_op[0], 5));
        $id = 0;
        $alias = '';
    } elseif (empty($alias) and empty($page_config['viewtype'])) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data)
            ->where('status=1')
            ->order('weight ASC')
            ->limit(1);
        $rowdetail = $db_slave->query($db_slave->sql())
            ->fetch();
        if (!empty($rowdetail)) {
            $id = $rowdetail['id'];
        }
    } elseif (!empty($alias)) {
        $sth = $db_slave->prepare('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE alias=:alias');
        $sth->bindParam(':alias', $alias, PDO::PARAM_STR);
        $sth->execute();
        $rowdetail = $sth->fetch();
        if (empty($rowdetail)) {
            nv_redirect_location($base_url);
        }
        $id = $rowdetail['id'];
    }
}

// Handle different operations
$op = $array_op[0] ?? 'main';

switch ($op) {
    case 'categories':
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/categories.php';
        break;
    case 'dashboard':
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/dashboard.php';
        break;
    case 'search':
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/search.php';
        break;
    case 'export':
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/export.php';
        break;
    case 'api':
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/api.php';
        break;
    default:
        include NV_ROOTDIR . '/modules/' . $module_file . '/funcs/main.php';
        break;
}
