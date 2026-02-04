<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_name . '/admin.functions.php';

$id = $nv_Request->get_int('id', 'get', 0);
if (!$id) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Get task info before delete
$result = $db->query('SELECT checkin_image, checkout_image, report_file FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id = ' . $id);
if ($result->rowCount()) {
    $row = $result->fetch();
    
    // Delete files
    if (!empty($row['checkin_image']) && file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['checkin_image'])) {
        @unlink(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['checkin_image']);
    }
    if (!empty($row['checkout_image']) && file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['checkout_image'])) {
        @unlink(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['checkout_image']);
    }
    if (!empty($row['report_file']) && file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['report_file'])) {
        @unlink(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['report_file']);
    }
}

// Delete task
$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id = ' . $id);

nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);