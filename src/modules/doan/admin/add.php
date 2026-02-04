<?php

/**
 * Module Do An - Add
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

// Include Smarty
require_once NV_ROOTDIR . '/vendor/smarty/smarty/libs/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir(NV_ROOTDIR . '/modules/' . $module_name . '/admin/templates/');
$smarty->setCompileDir(NV_ROOTDIR . '/data/tmp/');
$smarty->setCacheDir(NV_ROOTDIR . '/data/cache/');

// Handle form submission
if ($nv_Request->isset_request('submit', 'post')) {
    $ten = $nv_Request->get_title('ten', 'post', '');
    $mo_ta = $nv_Request->get_textarea('mo_ta', 'post', '');

    // Insert into database
    try {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (ten, mo_ta, addtime) VALUES (:ten, :mo_ta, :addtime)');
        $stmt->bindValue(':ten', $ten, PDO::PARAM_STR);
        $stmt->bindValue(':mo_ta', $mo_ta, PDO::PARAM_STR);
        $stmt->bindValue(':addtime', NV_CURRENTTIME, PDO::PARAM_INT);
        $stmt->execute();
    } catch (Exception $e) {
        // Ignore error if table not exists
    }

    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Assign variables to Smarty
$smarty->assign('LANG', $nv_Lang);
$smarty->assign('MODULE_NAME', $module_name);
$smarty->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$smarty->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$smarty->assign('NV_LANG_DATA', NV_LANG_DATA);
$smarty->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);

// Display template
$contents = $smarty->fetch('add.tpl');

$page_title = 'Thêm đồ án';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

?>