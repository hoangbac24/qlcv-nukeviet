<?php

/**
 * User Dashboard - Personal Tasks View
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

// Check if user is logged in
if (!defined('NV_IS_USER')) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $nv_Lang->getModule('dashboard');
$key_words = 'qlcv, dashboard, tasks';

$per_page = 10;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=dashboard';

// Get categories for filter
$global_array_cat = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $global_array_cat[$row['id']] = $row;
}

// Query user's tasks
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_tasks')
    ->where('userid = ' . $user_info['userid']);

$num_items = $db->query($db->sql())->fetchColumn();

$db->select('id, catid, title, description, status, add_time, checkin_image, checkout_image, report_file')
    ->order('add_time DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$result = $db->query($db->sql());
$array_data = [];
while ($row = $result->fetch()) {
    $row['category'] = isset($global_array_cat[$row['catid']]) ? $global_array_cat[$row['catid']]['title'] : 'N/A';
    $row['status_text'] = $row['status'] ? $nv_Lang->getModule('completed') : $nv_Lang->getModule('pending');

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

    $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
    $array_data[] = $row;
}

// Generate page
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

// Use XTemplate
$xtpl = new XTemplate('dashboard.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_FILE', $module_file);
$xtpl->assign('PAGE', $page);
$xtpl->assign('GENERATE_PAGE', $generate_page);
$xtpl->assign('USER_INFO', $user_info);

foreach ($array_data as $data) {
    $data['add_time'] = date('d/m/Y H:i', $data['add_time']);
    $xtpl->assign('DATA', $data);
    
    // Handle conditional blocks for images and files
    if (!empty($data['checkin_image_url'])) {
        $xtpl->parse('main.loop.checkin_image');
    }
    if (!empty($data['checkout_image_url'])) {
        $xtpl->parse('main.loop.checkout_image');
    }
    if (!empty($data['report_file_url'])) {
        $xtpl->parse('main.loop.report_file');
    }
    
    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';