<?php

/**
 * @Project NukeViet 5.x
 * @Author Antigravity
 * @copyright 2026
 * @License GNU/GPL version 2 or any later version
 * @createdate 11/02/2026
 */

if (!defined('NV_IS_MOD_QLCV')) {
    exit('Stop!!!');
}

$id = $nv_Request->get_int('id', 'get', 0);

if ($id > 0) {
    $stmt = $db->prepare('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_jobs WHERE id = :id AND status = 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();

    if ($row) {
        $page_title = $row['title'];
        $row['add_time'] = date('d/m/Y H:i', $row['add_time']);
        $row['edit_time'] = date('d/m/Y H:i', $row['edit_time']);

        $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', $nv_Lang);
        $xtpl->assign('MODULE_NAME', $module_name);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);

        if (!empty($row['image_checkin'])) {
            $row['image_checkin'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image_checkin'];
            $xtpl->parse('main.image_checkin');
        }
        if (!empty($row['image_checkout'])) {
            $row['image_checkout'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image_checkout'];
            $xtpl->parse('main.image_checkout');
        }
        if (!empty($row['file_report'])) {
            $row['file_report'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['file_report'];
            $xtpl->parse('main.file_report');
        }

        $xtpl->assign('DATA', $row);

        $xtpl->parse('main');
        $contents = $xtpl->text('main');

        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    } else {
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
} else {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}
