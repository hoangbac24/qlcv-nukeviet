<?php

/**
 * Module QLCV - Add
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_name . '/admin.functions.php';

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
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tasks (catid, userid, title, description, status, add_time, checkin_image, checkout_image, report_file) VALUES (:catid, :userid, :title, :description, :status, :add_time, :checkin_image, :checkout_image, :report_file)');
        $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);
        $stmt->bindValue(':userid', $admin_info['userid'], PDO::PARAM_INT);
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

// Use XTemplate
$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('CATEGORIES', $categories);

// Display template
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = 'Thêm công việc';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';