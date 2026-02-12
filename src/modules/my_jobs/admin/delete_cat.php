<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$id = $nv_Request->get_int('id', 'get', 0);

if ($id > 0) {
    // Check if category is used in jobs
    $count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_jobs WHERE catid = ' . $id)->fetchColumn();
    if ($count > 0) {
        $contents = 'Error: Cannot delete category because it contains jobs. Please delete jobs first.';
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
        exit;
    }

    $stmt = $db->prepare('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=categories');
