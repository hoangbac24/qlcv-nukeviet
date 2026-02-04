<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_file . '/admin.functions.php';

global $db, $nv_Request, $module_file;

$page_title = 'Quản lý danh mục công việc';

$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);

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
    $row['edit_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=edit_cat&id=' . $row['id'];
    $row['delete_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=delete_cat&id=' . $row['id'];
    $array_data[] = $row;
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=categories';

// Generate page
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('categories.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('GENERATE_PAGE', $generate_page);

foreach ($array_data as $data) {
    $data['add_time'] = date('d/m/Y H:i', $data['add_time']);
    $xtpl->assign('DATA', $data);
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';