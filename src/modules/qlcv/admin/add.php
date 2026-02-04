<?php

/**
 * Module QLCV - Add
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_name . '/admin.functions.php';

// Include Smarty
require_once NV_ROOTDIR . '/vendor/smarty/smarty/libs/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir(NV_ROOTDIR . '/modules/' . $module_name . '/admin/templates/');
$smarty->setCompileDir(NV_ROOTDIR . '/data/tmp/');
$smarty->setCacheDir(NV_ROOTDIR . '/data/cache/');

// Handle form submission
if ($nv_Request->isset_request('submit', 'post')) {
    $catid = $nv_Request->get_int('catid', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '');
    $description = $nv_Request->get_textarea('description', 'post', '');
    $status = $nv_Request->get_int('status', 'post', 0);

    // Handle file uploads
    $checkin_image = '';
    $checkout_image = '';
    $report_file = '';

    // Upload checkin image
    if (isset($_FILES['checkin_image']) && is_uploaded_file($_FILES['checkin_image']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload(['images'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage($lang_global);
        $upload_info = $upload->save_file($_FILES['checkin_image'], NV_UPLOADS_REAL_DIR . '/' . $module_upload, false, $global_config['nv_auto_resize']);
        if (empty($upload_info['error'])) {
            $checkin_image = $upload_info['basename'];
        }
    }

    // Upload checkout image
    if (isset($_FILES['checkout_image']) && is_uploaded_file($_FILES['checkout_image']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload(['images'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage($lang_global);
        $upload_info = $upload->save_file($_FILES['checkout_image'], NV_UPLOADS_REAL_DIR . '/' . $module_upload, false, $global_config['nv_auto_resize']);
        if (empty($upload_info['error'])) {
            $checkout_image = $upload_info['basename'];
        }
    }

    // Upload report file
    if (isset($_FILES['report_file']) && is_uploaded_file($_FILES['report_file']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload(['documents', 'archives'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage($lang_global);
        $upload_info = $upload->save_file($_FILES['report_file'], NV_UPLOADS_REAL_DIR . '/' . $module_upload, false, $global_config['nv_auto_resize']);
        if (empty($upload_info['error'])) {
            $report_file = $upload_info['basename'];
        }
    }

    // Insert into database
    try {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tasks (catid, title, description, status, add_time, checkin_image, checkout_image, report_file) VALUES (:catid, :title, :description, :status, :add_time, :checkin_image, :checkout_image, :report_file)');
        $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->bindValue(':checkin_image', $checkin_image, PDO::PARAM_STR);
        $stmt->bindValue(':checkout_image', $checkout_image, PDO::PARAM_STR);
        $stmt->bindValue(':report_file', $report_file, PDO::PARAM_STR);
        $stmt->execute();
    } catch (Exception $e) {
        // Ignore error if table not exists
    }

    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Get categories for select
$categories = [];
$result = $db->query('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
while ($row = $result->fetch()) {
    $categories[] = $row;
}

// Assign variables to Smarty
$smarty->assign('LANG', $nv_Lang);
$smarty->assign('MODULE_NAME', $module_name);
$smarty->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$smarty->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$smarty->assign('NV_LANG_DATA', NV_LANG_DATA);
$smarty->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$smarty->assign('CATEGORIES', $categories);

// Display template
$contents = $smarty->fetch('add.tpl');

$page_title = 'Thêm công việc';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';