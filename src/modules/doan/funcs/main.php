<?php

/**
 * Module Do An - Main
 */

if (!defined('NV_IS_MOD_DOAN')) {
    exit('Stop!!!');
}

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];

$array_data = [];

// Query data from database
try {
    $result = $db->query('SELECT id, ten, mo_ta, addtime FROM ' . NV_PREFIXLANG . '_' . $module_data . ' ORDER BY addtime DESC');
    while ($row = $result->fetch()) {
        $array_data[] = $row;
    }
} catch (Exception $e) {
    // If table not exists, show empty
}

// Use XTemplate
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);

foreach ($array_data as $data) {
    $xtpl->assign('DATA', $data);
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

?>