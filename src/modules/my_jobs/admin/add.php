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

$page_title = 'Add Job';

// Fetch categories
$stmt = $db->prepare('SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_categories ORDER BY weight ASC');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($nv_Request->isset_request('submit', 'post')) {
    $catid = $nv_Request->get_int('catid', 'post', 0);
    $title = $nv_Request->get_title('title', 'post', '');
    $description = $nv_Request->get_textarea('description', 'post', '');
    $content = $nv_Request->get_editor('content', '', NV_ALLOWED_HTML_TAGS);
    $status = $nv_Request->isset_request('status', 'post') ? 1 : 0;

    if (empty($title)) {
        $error = 'Error: Title cannot be empty';
    } elseif ($catid == 0) {
        $error = 'Error: Please select a category';
    } else {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_jobs (catid, title, description, content, status, add_time, edit_time) VALUES (:catid, :title, :description, :content, :status, :add_time, :edit_time)');
        $stmt->bindValue(':catid', $catid, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->execute();

        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }
}

$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('OP', $op);

foreach ($categories as $cat) {
    $xtpl->assign('CAT', $cat);
    $xtpl->parse('main.cat_loop');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$content = isset($content) ? $content : '';
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $content = nv_aleditor('content', '100%', '300px', $content);
} else {
    $content = '<textarea style="width:100%;height:300px" name="content">' . $content . '</textarea>';
}
$xtpl->assign('CONTENT', $content);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
