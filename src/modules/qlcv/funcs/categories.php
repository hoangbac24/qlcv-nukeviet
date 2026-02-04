<?php

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

$page_title = 'Danh mục công việc';
$key_words = 'qlcv';

$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=categories';

// Query categories
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_categories');

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, title, description, weight, add_time')
    ->order('weight ASC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array_data = [];
while ($row = $result->fetch()) {
    $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
    $array_data[] = $row;
}

// Generate page
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('categories.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('PAGE', $page);
$xtpl->assign('GENERATE_PAGE', $generate_page);

foreach ($array_data as $data) {
    $data['add_time'] = date('d/m/Y H:i', $data['add_time']);
    $xtpl->assign('DATA', $data);
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';