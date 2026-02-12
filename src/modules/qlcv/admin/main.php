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


// Check and fix schema if missing columns
$check_cols = $db->query("SHOW COLUMNS FROM " . NV_PREFIXLANG . "_" . $module_data . "_jobs LIKE 'image_checkin'")->fetch();
if (!$check_cols) {
    $db->query("ALTER TABLE " . NV_PREFIXLANG . "_" . $module_data . "_jobs ADD COLUMN image_checkin VARCHAR(255) DEFAULT '' AFTER content");
}

$check_cols = $db->query("SHOW COLUMNS FROM " . NV_PREFIXLANG . "_" . $module_data . "_jobs LIKE 'file_report'")->fetch();
if (!$check_cols) {
    $db->query("ALTER TABLE " . NV_PREFIXLANG . "_" . $module_data . "_jobs ADD COLUMN file_report VARCHAR(255) DEFAULT '' AFTER image_checkin");
}

$page_title = 'Quản lý công việc';

$per_page = 1;
$page = $nv_Request->get_int('page', 'get', 1);

$q = $nv_Request->get_title('q', 'get', '');
$where = '';
$params = [];

if (!empty($q)) {
    $where = 'WHERE (a.title LIKE :q1 OR b.title LIKE :q2)';
    $params[':q1'] = '%' . $q . '%';
    $params[':q2'] = '%' . $q . '%';
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_jobs a')
    ->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_categories b ON a.catid = b.id');

if (!empty($where)) {
    $db->where(str_replace('WHERE ', '', $where)); // Remove WHERE for db->where()
}

$stmt_count = $db->prepare($db->sql());
foreach ($params as $key => $value) {
    $stmt_count->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt_count->execute();
$num_items = $stmt_count->fetchColumn();

$db->select('a.id, a.title, a.status, a.add_time, a.image_checkin, a.description, b.title as cat_title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_jobs a')
    ->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_categories b ON a.catid = b.id')
    ->order('a.add_time DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

if (!empty($where)) {
    $db->where(str_replace('WHERE ', '', $where));
}

$stmt = $db->prepare($db->sql());
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}
$stmt->execute();
$array_data = [];
$stt = ($page - 1) * $per_page;

while ($row = $stmt->fetch()) {
    $stt++;
    $row['stt'] = $stt;
    $row['edit_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=edit&id=' . $row['id'];
    $row['delete_link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&op=delete&id=' . $row['id'];
    $row['status_text'] = $row['status'] == 1 ? 'Hoạt động' : 'Tạm dừng';

    if (!empty($row['image_checkin'])) {
        $row['checkin_image_url'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image_checkin'];
    }

    $array_data[] = $row;
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
if (!empty($q)) {
    $base_url .= '&q=' . $q;
}
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['admin_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $nv_Lang);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('Q', $q);
$xtpl->assign('GENERATE_PAGE', $generate_page);

if (!empty($q)) {
    $xtpl->parse('main.search_info');
}

foreach ($array_data as $data) {
    $data['add_time'] = date('d/m/Y H:i', $data['add_time']);
    $xtpl->assign('DATA', $data);



    if (!empty($data['checkin_image_url'])) {
        $xtpl->parse('main.loop.checkin_image');
    }

    $xtpl->parse('main.loop');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
