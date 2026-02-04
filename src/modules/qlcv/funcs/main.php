<?php

/**
 * @Project Module Nukeviet 4.x
 * @Author Generated
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 03/02/2026
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

$page_title = 'Danh sách công việc';
$key_words = 'qlcv';

$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;

// Get categories
$global_array_cat = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $global_array_cat[$row['id']] = $row;
}

// Query tasks
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_tasks');

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, catid, title, description, status, add_time, checkin_image, checkout_image, report_file')
    ->order('add_time DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array_data = [];
while ($row = $result->fetch()) {
    $row['category'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';
    
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
    
    $array_data[] = $row;
}

// Generate page
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
