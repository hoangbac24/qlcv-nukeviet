<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    die('STOP ADMIN');
}

$page_title = $nv_Lang->getModule('main');

// Get page number
$page = $nv_Request->get_int('page', 'get', 1);
$per_page = 10;

// Get total items
$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks';
$result = $db->query($sql);
$num_items = $result->fetchColumn();

// Get data
$sql = 'SELECT t.*, c.title as cat_title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks t
        LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_categories c ON t.catid = c.id
        ORDER BY t.id DESC LIMIT ' . ($page - 1) * $per_page . ', ' . $per_page;
$result = $db->query($sql);

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=main';

// Generate page
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('GENERATE_PAGE', $generate_page);

while ($row = $result->fetch()) {
    $row['edit_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=edit&id=' . $row['id'];
    $row['delete_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=delete&id=' . $row['id'];
    $row['status_text'] = $row['status'] ? 'Hoàn thành' : 'Chưa hoàn thành';
    $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
    
    // Handle images and files
    if (!empty($row['checkin_image'])) {
        $row['checkin_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['checkin_image'];
    }
    if (!empty($row['checkout_image'])) {
        $row['checkout_image_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['checkout_image'];
    }
    if (!empty($row['report_file'])) {
        $row['report_file_url'] = NV_BASE_SITEURL . 'uploads/' . $module_upload . '/' . $row['report_file'];
    }
    
    $xtpl->assign('DATA', $row);
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
