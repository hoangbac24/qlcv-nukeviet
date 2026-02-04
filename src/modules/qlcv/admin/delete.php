<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/modules/' . $module_name . '/admin.functions.php';

/**
 * Safely delete file within module upload directory
 * Note: Path validation is performed before unlink to prevent directory traversal
 */
function safe_delete_file($filename, $module_upload) {
    if (empty($filename)) {
        return false;
    }
    
    // Sanitize filename - only allow safe characters
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', basename($filename));
    
    // Build full path
    $upload_dir = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/';
    $file_path = $upload_dir . $filename;
    
    // Validate path is within upload directory using multiple checks
    $real_upload_dir = realpath($upload_dir);
    $real_file_path = realpath($file_path);
    
    // Additional security: ensure no path traversal
    if ($real_file_path && $real_upload_dir && 
        strpos($real_file_path, $real_upload_dir) === 0 && 
        substr_count($real_file_path, '..') === 0 &&
        file_exists($real_file_path)) {
        
        // Use a more secure approach - check if file is readable first
        if (is_readable($real_file_path)) {
            return unlink($real_file_path);
        }
    }
    
    return false;
}

$id = $nv_Request->get_int('id', 'get', 0);
if (!$id) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Get task info before delete
$result = $db->query('SELECT checkin_image, checkout_image, report_file FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id = ' . $id);
if ($result->rowCount()) {
    $row = $result->fetch();
    
    // Delete files securely
    safe_delete_file($row['checkin_image'], $module_upload);
    safe_delete_file($row['checkout_image'], $module_upload);
    safe_delete_file($row['report_file'], $module_upload);
}

// Delete task
$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id = ' . $id);

nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);